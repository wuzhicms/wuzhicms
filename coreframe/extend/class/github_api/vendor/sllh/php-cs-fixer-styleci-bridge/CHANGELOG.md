# CHANGELOG

* 1.6.2 (2016-04-18)

 * Enable `sllh/styleci-fixers` 4.0.

* 1.6.1 (2016-04-17)

 * Fix bad namespace issue with php-cs-fixer 2.x.

* 1.6.0 (2016-04-17)

 * StyleCI fixers updated (`sllh/styleci-fixers` 3.0).
 * Fix some compatibility issues with php-cs-fixer 2.x.

* 1.5.0 (2015-12-06)

 * Manage StyleCI `risky` option.

* 1.4.1 (2015-11-19)

 * Manage single scalar values for `enabled`, `disabled` and `finder` configuration keys.

* 1.4.0 (2015-11-10)

 * Extract StyleCI fixers generator outside of this project,
 using [sllh/styleci-fixers](https://github.com/Soullivaneuh/styleci-fixers).
 * Allow Symfony 3 dependencies.

* 1.3.3 (2015-10-16)

 * Use a custom psr-4 loader to avoid code conflict.
 * Guess config files path using php backtrace. This avoid issues on subdirectories.

* 1.3.2 (2015-10-05)

 * Use [composer/semver](https://packagist.org/packages/composer/semver) for better compatibility check.

* 1.3.1 (2015-09-30)

 * Use `FixerFactory::hasRule` instead of building our own fixers array by name.

* 1.3.0 (2015-09-29)

 * PHP-CS-Fixer version check.
 * Use Symfony Config component for `.styleci.yml` parsing.
 * Manage fixers conflicts.

* 1.2.1 (2015-09-28)

 * Fix some BC breaks with PHP-CS-Fixer 2.0.

* 1.2.0 (2015-09-25)

 * Resolve fixer aliases for better compatibility with PHP-CS-Fixer 1.x and 2.x.

* 1.1.0 (2015-09-24)

 * Load fixers from StyleCI config instead of PHP-CS-Fixer.
 * Deprecate `ConfigBridge::getFixers`.
