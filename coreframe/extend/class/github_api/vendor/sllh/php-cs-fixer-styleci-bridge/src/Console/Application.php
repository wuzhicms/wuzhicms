<?php

namespace SLLH\StyleCIBridge\Console;

use SLLH\StyleCIBridge\Console\Command\StyleCIConfigCheckCommand;
use SLLH\StyleCIBridge\Console\Command\StyleCIConfigUpdateCommand;
use Symfony\Component\Console\Application as BaseApplication;

@trigger_error('The '.__NAMESPACE__.'\Application class is deprecated since 1.4 and will be removed in 2.0.', E_USER_DEPRECATED);

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @deprecated since 1.4, will be removed in 2.0.
 */
class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->add(new StyleCIConfigUpdateCommand());
        $this->add(new StyleCIConfigCheckCommand());
    }
}
