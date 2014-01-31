Librette/Doctrine Migrations
===========================


Requirements
------------

- PHP 5.3.2 or higher.
- [Nette Framework 2.1.x](https://github.com/nette/nette)
- [Kdyby/Console](https://github.com/kdyby/console)
- [Kdyby/Events](https://github.com/kdyby/events)
- [Doctrine DBAL](https://github.com/doctrine/dbal)

Recommended:

- [Doctrine ORM 2.4.x](https://github.com/doctrine/orm)
- [Kdyby/Doctrine](https://github.com/kdyby/doctrine)


Installation
------------

The best way to install this extension is using  [Composer](http://getcomposer.org/):

```sh
$ composer require librette/doctrine-migrations
```

Now you have to register this extension in your config.neon

```yml
extensions:
	migrations: Librette\Doctrine\Migrations\MigrationsExtension
```

Configuration
------------

If you have already configured Doctrine, you don't have to configure anything else, but there are few things you can configure:

```yml
migrations:
	name: My migrations
	migrationsNamespace: MigrationsNamespace
	tableName: doctrine_migration_versions
	migrationsDirectory: %appDir%/migrations
	migrations:
		myMigration:
			version: 123
			class: MyMigration123
```

Default values of migrationsNamespace, tableName and migrationsDirectory are the same as you see in example above.

Migrations directory must exists and must be writable.


Usage
-------------

Simply run Kdyby\Console and you should be able to use new commands.

For more detailed information about Doctrine Migrations visit [Doctrine Migrations documentation](http://docs.doctrine-project.org/projects/doctrine-migrations/en/latest/)