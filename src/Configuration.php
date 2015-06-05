<?php
namespace Librette\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\Configuration\Configuration as BaseConfiguration;

/**
 * @author David Matejka
 */
class Configuration extends BaseConfiguration
{

	private $scheduledDirectoryRegistration = [];


	public function scheduleRegisterMigrationsFromDirectory($dir)
	{
		if ($this->getConnection()->isConnected()) {
			$this->registerMigrationsFromDirectory($dir);
		} else {
			$this->scheduledDirectoryRegistration[] = $dir;
		}
	}


	public function getMigrations()
	{
		$this->doRegister();

		return parent::getMigrations();
	}


	public function getVersion($version)
	{
		$this->doRegister();

		return parent::getVersion($version);
	}


	public function getAvailableVersions()
	{
		$this->doRegister();

		return parent::getAvailableVersions();
	}


	public function getCurrentVersion()
	{
		$this->doRegister();

		return parent::getCurrentVersion();
	}


	public function getRelativeVersion($version, $delta)
	{
		$this->doRegister();

		return parent::getRelativeVersion($version, $delta);
	}


	public function getNumberOfAvailableMigrations()
	{
		$this->doRegister();

		return parent::getNumberOfAvailableMigrations();
	}


	public function getLatestVersion()
	{
		$this->doRegister();

		return parent::getLatestVersion();
	}


	public function getMigrationsToExecute($direction, $to)
	{
		$this->doRegister();

		return parent::getMigrationsToExecute($direction, $to);
	}


	public function hasVersion($version)
	{
		$this->doRegister();

		return parent::hasVersion($version);
	}


	private function doRegister()
	{
		foreach ($this->scheduledDirectoryRegistration as $dir) {
			$this->registerMigrationsFromDirectory($dir);
		}
		$this->scheduledDirectoryRegistration = [];
	}

}
