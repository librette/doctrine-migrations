<?php
namespace Librette\Doctrine\Migrations;

use Kdyby\Console\DI\ConsoleExtension;
use Kdyby\Events\DI\EventsExtension;
use Nette\DI\CompilerExtension;
use Nette;

class MigrationsExtension extends CompilerExtension
{

	public $defaults = array(
		'name'                => NULL,
		'tableName'           => NULL,
		'migrationsNamespace' => 'DoctrineMigrations',
		'migrationsDirectory' => '%appDir%/migrations',
		'migrations'          => array(),
		'disabled'            => FALSE,
	);

	public $commands = array(
		'Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand',
		'Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand',
		'Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand',
		'Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand',
		'Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand',
		'Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand',
	);


	function __construct()
	{
		$this->defaults['disabled'] = PHP_SAPI !== 'cli';
	}


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);
		if ($config['disabled']) {
			return;
		}

		$builder->addDefinition($this->prefix('outputWriter'))
				->setClass('Librette\Doctrine\Migrations\OutputWriter');

		$builder->addDefinition($this->prefix('outputInterfaceLinker'))
				->setClass('Librette\Doctrine\Migrations\OutputInterfaceLinker')
				->addTag(EventsExtension::SUBSCRIBER_TAG);

		$configuration = $builder->addDefinition($this->prefix('configuration'));
		$configuration->setClass('Doctrine\DBAL\Migrations\Configuration\Configuration');
		$configuration->addSetup('setMigrationsDirectory', array($config['migrationsDirectory']));
		$configuration->addSetup('setMigrationsNamespace', array($config['migrationsNamespace']));
		$configuration->addSetup('registerMigrationsFromDirectory', array($config['migrationsDirectory']));
		if (isset($config['name'])) {
			$configuration->addSetup('setName', array($config['name']));
		}
		if (isset($config['tableName'])) {
			$configuration->addSetup('setMigrationsTableName', array($config['tableName']));
		}
		Nette\Utils\Validators::assert($config['migrations'], 'array');
		foreach ($config['migrations'] as $migration) {
			$configuration->addSetup('registerMigration', array($migration['version'], $migration['class']));
		}

		foreach ($this->commands as $i => $class) {
			$command = $builder->addDefinition($this->prefix('command.' . $i));
			$command->setClass($class)
					->addSetup('setMigrationConfiguration', array($configuration))
					->addTag(ConsoleExtension::COMMAND_TAG);
		}
	}

}