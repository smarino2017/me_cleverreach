<?php

namespace MoveElevator\MeCleverreach\Service;

use \TYPO3\CMS\Extbase\Mvc\Request;
use \TYPO3\CMS\Core\Resource\Exception\InvalidConfigurationException;

/**
 * Class SubscribeController
 *
 * @package MoveElevator\MeCleverreach\Service
 */
class SubscribeService extends AbstractBaseService {

	/**
	 * @var \TYPO3\CMS\Extbase\Mvc\Request
	 */
	protected $request;

	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * @param array $settings
	 * @param \TYPO3\CMS\Extbase\Mvc\Request $request
	 * @return void
	 */
	public function initializeServiceProperties(array $settings, Request $request) {
		$this->settings = $settings;
		$this->request = $request;
	}

	/**
	 * @return array
	 */
	public function generateUserData() {
		$this->_validateServiceProperties();

		$userData = array();

		$userData['source'] = $this->settings['source'];
		$userData['registered'] = time();

		$userData['email'] = $this->request->getArgument('email');
		$userData['attributes'] = $this->request->getArgument('email');

		$userData['attributes'] = $this->convertAttributes($this->request->getArguments());

		return $userData;
	}

	/**
	 * @return bool
	 */
	protected function _checkServiceProperties() {
		$isValid = TRUE;

		if (!is_array($this->settings) || count($this->settings) === 0) {
			$isValid = FALSE;
		}

		if (!$this->request instanceof Request && $isValid === TRUE) {
			$isValid = FALSE;
		}

		return $isValid;
	}

	/**
	 * @throws \TYPO3\CMS\Core\Resource\Exception\InvalidConfigurationException
	 */
	protected function _validateServiceProperties() {
		if ($this->_checkServiceProperties() === FALSE) {
			throw new InvalidConfigurationException('Service properties not initialized.');
		}
	}
}