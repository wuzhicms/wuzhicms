<?php

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @link https://github.com/composer/composer/issues/1493#issuecomment-12492276
 */
class CustomLoader
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $loader;

    /**
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function __construct($loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param string $class The class name
     *
     * @return bool|null
     */
    public function loadClass($class)
    {
        $result = $this->loader->loadClass($class);

        if ($result && method_exists($class, '__static')) {
            call_user_func(array($class, '__static'));
        }

        return $result;
    }
}

if (file_exists(__DIR__.'/../../autoload.php')) {
    $loader = require __DIR__.'/../../autoload.php';
} else {
    $loader = require __DIR__.'/vendor/autoload.php';
}
$loader->unregister();
spl_autoload_register(array(new CustomLoader($loader), 'loadClass'));
