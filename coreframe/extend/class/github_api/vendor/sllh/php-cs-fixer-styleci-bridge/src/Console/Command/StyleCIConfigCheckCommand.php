<?php

namespace SLLH\StyleCIBridge\Console\Command;

use SLLH\StyleCIBridge\StyleCI\FixersGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

@trigger_error('The '.__NAMESPACE__.'\StyleCIConfigCheckCommand class is deprecated since 1.4 and will be removed in 2.0.', E_USER_DEPRECATED);

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @deprecated since 1.4, will be removed in 2.0.
 */
class StyleCIConfigCheckCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('styleci:config:check')
            ->setDescription('Check if StyleCI fixers config is up to date.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixersClass = file_get_contents(__DIR__.'/../../StyleCI/Fixers.php');

        $generator = new FixersGenerator();

        if ($fixersClass === $generator->getFixersClass()) {
            $output->writeln('StyleCI fixers are up to date.');
        } else {
            $output->writeln('<error>StyleCI fixers are out of date. Run styleci:config:update command to fix it.</error>');

            return 1;
        }

        return 0;
    }
}
