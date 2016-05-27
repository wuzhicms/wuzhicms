# PHP-CS-Fixer StyleCI bridge

Auto configure [PHP-CS-Fixer](http://cs.sensiolabs.org/) from [StyleCI](https://styleci.io/) config file.

This library permits to generate php-cs-fixer configuration directly from your `.styleci.yml` config file.

With that, you will avoid the pain of both config files maintenance.

[![Latest Stable Version](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/v/stable)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)
[![Latest Unstable Version](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/v/unstable)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)
[![License](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/license)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)
[![Dependency Status](https://www.versioneye.com/php/sllh:php-cs-fixer-styleci-bridge/badge.svg)](https://www.versioneye.com/php/sllh:php-cs-fixer-styleci-bridge)
[![Reference Status](https://www.versioneye.com/php/sllh:php-cs-fixer-styleci-bridge/reference_badge.svg)](https://www.versioneye.com/php/sllh:php-cs-fixer-styleci-bridge/references)

[![Total Downloads](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/downloads)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)
[![Monthly Downloads](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/d/monthly)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)
[![Daily Downloads](https://poser.pugx.org/sllh/php-cs-fixer-styleci-bridge/d/daily)](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge)

[![Build Status](https://travis-ci.org/Soullivaneuh/php-cs-fixer-styleci-bridge.svg?branch=1.x)](https://travis-ci.org/Soullivaneuh/php-cs-fixer-styleci-bridge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Soullivaneuh/php-cs-fixer-styleci-bridge/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/Soullivaneuh/php-cs-fixer-styleci-bridge/?branch=1.x)
[![Code Climate](https://codeclimate.com/github/Soullivaneuh/php-cs-fixer-styleci-bridge/badges/gpa.svg)](https://codeclimate.com/github/Soullivaneuh/php-cs-fixer-styleci-bridge)
[![Coverage Status](https://coveralls.io/repos/Soullivaneuh/php-cs-fixer-styleci-bridge/badge.svg?branch=1.x)](https://coveralls.io/r/Soullivaneuh/php-cs-fixer-styleci-bridge?branch=1.x)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f04c9b72-91a8-4ad7-9e7f-ce6dfc66df78/mini.png)](https://insight.sensiolabs.com/projects/f04c9b72-91a8-4ad7-9e7f-ce6dfc66df78)

## Who is using this?

You can see which projects are using this package on the dedicated [Packagist page](https://packagist.org/packages/sllh/php-cs-fixer-styleci-bridge/dependents).

## Installation

Include this library on your dev dependencies:

```bash
composer require --dev sllh/php-cs-fixer-styleci-bridge
```

## Usage

You can use this bridge with several manners.

### Basic usage

Put the following config on your `.php_cs` file:

```php
<?php

// Needed to get styleci-bridge loaded
require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

return ConfigBridge::create();
```

With this configuration, the configuration bridge will just parse your `.styleci.yml` file.

Sample working file:

```yaml
preset: symfony

enabled:
  - align_double_arrow
  - newline_after_open_tag
  - ordered_use
  - long_array_syntax

disabled:
  - unalign_double_arrow
  - unalign_equals
```

### Directories options

You can change default repository of your `.styleci.yml` file and directories for the CS Finder directly on `ConfigBridge::create` method or constructor.

```php
<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

return ConfigBridge::create(__DIR__.'/config', [__DIR__, __DIR__.'../lib']);
```

### Customize the configuration class

`ConfigBridge::create` returns a `Symfony\CS\Config\Config` that you can customize as you want.

```php
<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

return ConfigBridge::create()
    ->setUsingCache(true)       // Enable the cache
;
```

### Using the bridge

You can also using bridge method, part by part.

```php
<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;
use Symfony\CS\Config\Config;

$bridge = new ConfigBridge();

return Config::create()
    ->finder($bridge->getFinder())
    ->fixers(['dummy', 'foo', '-bar'])
    ->setUsingCache(true)
;
```

### Manually enable or disable fixers

To enable or disable some fixers manually on the `.php_cs` file,
you will have to use merge system to keep fixers defined by the bridge:

```php
require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

$config = ConfigBridge::create();

return $config
    ->setUsingCache(true)
    ->fixers(array_merge($config->getFixers(), ['-psr0', 'custom', 'foo', '-bar']))
;
```

### Header comment

Unfortunately, header comment option [is not available](https://twitter.com/soullivaneuh/status/644795113399582720) on StyleCI config file.

You will have to copy it from StyleCI web interface and set it manually.

The config bridge will automatically detect the fixer and add it on CS configuration.

#### PHP-CS-Fixer 1.x

```php
<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;

$header = <<<EOF
This file is part of the dummy package.

(c) John Doe <john@doe.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

HeaderCommentFixer::setHeader($header);

return ConfigBridge::create();
```

#### PHP-CS-Fixer 2.x

```php
<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

$header = <<<EOF
This file is part of the dummy package.

(c) John Doe <john@doe.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$config = ConfigBridge::create();

return $config
    ->setRules(array_merge($config->getRules(), array(
        'header_comment' => array('header' => $header)
    )))
;
```

#### Both versions

You can handle both versions easily with some magic `method_exists` tricks:

```php
<?php

require __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;

$header = <<<EOF
This file is part of the dummy package.

(c) John Doe <john@doe.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

// PHP-CS-Fixer 1.x
if (method_exists('Symfony\CS\Fixer\Contrib\HeaderCommentFixer', 'getHeader')) {
    HeaderCommentFixer::setHeader($header);
}

$config = ConfigBridge::create();

// PHP-CS-Fixer 2.x
if (method_exists($config, 'setRules')) {
    $config->setRules(array_merge($config->getRules(), array(
        'header_comment' => array('header' => $header)
    )));
}

return $config;
```

## Troubleshooting

### Conflict with code or vendor library

In some edge cases, the bridge code may conflict with your code or your included vendor.

This kind of issue was discovered in [puli/cli#21 (comment)](https://github.com/puli/cli/pull/21#issuecomment-148438983)
and fixed since `v1.3.3` in [#47](https://github.com/Soullivaneuh/php-cs-fixer-styleci-bridge/pull/47).

Before that, you had to require the vendor autoload like this:

```php
require __DIR__.'/vendor/autoload.php';
```

This is not the secured way. Make sure to require our custom loader instead:

```php
require __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';
```
