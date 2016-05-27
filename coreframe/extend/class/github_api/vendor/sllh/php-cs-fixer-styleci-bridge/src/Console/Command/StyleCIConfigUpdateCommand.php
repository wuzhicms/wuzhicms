<?php

namespace SLLH\StyleCIBridge\Console\Command;

use SLLH\StyleCIBridge\StyleCI\FixersGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

@trigger_error('The '.__NAMESPACE__.'\StyleCIConfigUpdateCommand class is deprecated since 1.4 and will be removed in 2.0.', E_USER_DEPRECATED);

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @deprecated since 1.4, will be removed in 2.0.
 */
class StyleCIConfigUpdateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('styleci:config:update')
            ->setDescription('Update StyleCI fixers config from official repository.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = new FixersGenerator();
        $generator->generate();
    }
}
