<?php

require_once dirname(__FILE__) . '/../../../../../api/util/TPSettings.php';

class TPSiteSettingsTest extends PHPUnit_Framework_TestCase {

	public function testSettings() {

		$ss = new TPSiteSettings();

		//defaults
		$this->assertEquals(true, $ss->isEnabled());
		$this->assertEquals(true, $ss->isSand());
		$this->assertEquals("W7JZEZFu2h", $ss->getAID());
		$this->assertEquals("jeZC9ykDfvW6rXR8ZuO3EOkg9HaKFr90ERgEb3RW", $ss->getSecretKey());

		$ss->setProd();
		$this->assertEquals(true, $ss->isProd());
		$this->assertEquals(false, $ss->isSand());
		$this->assertEquals("GETKEY", $ss->getAID());
		$this->assertEquals("Retreive your secret key from www.tinypass.com", $ss->getSecretKey());
	}

	public function testCustomSettings() {
		$ss = new TPSiteSettings(array(
								TPSiteSettings::ENABLED => 'off',
								TPSiteSettings::AID_SAND => 'AID_SAND',
								TPSiteSettings::SECRET_KEY_SAND => 'KEY_SAND',
								TPSiteSettings::AID_PROD => 'AID_PROD',
								TPSiteSettings::SECRET_KEY_PROD => 'KEY_PROD',
								TPSiteSettings::ENV => 1,
						));
		$this->assertEquals(false, $ss->isEnabled());
		$this->assertEquals(false, $ss->isSand());
		$this->assertEquals("AID_PROD", $ss->getAID());
		$this->assertEquals("KEY_PROD", $ss->getSecretKey());

		$ss->setSand();
		$this->assertEquals("AID_SAND", $ss->getAID());
		$this->assertEquals("KEY_SAND", $ss->getSecretKey());
	}

	public function testMissingFields() {
		$ss = new TPSiteSettings(array());

		$this->assertEquals(false, $ss->isEnabled());
		$this->assertEquals(true, $ss->isSand());
		$this->assertEquals("GET_AID", $ss->getAID());
		$this->assertEquals("GET_KEY", $ss->getSecretKey());

		$ss->setSand();
		$this->assertEquals("GET_AID", $ss->getAID());
		$this->assertEquals("GET_KEY", $ss->getSecretKey());
	}



}

?>
