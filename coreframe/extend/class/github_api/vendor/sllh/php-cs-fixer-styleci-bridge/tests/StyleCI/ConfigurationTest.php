<?php

namespace SLLH\StyleCIBridge\Tests\StyleCI;

use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;
use SLLH\StyleCIBridge\StyleCI\Configuration;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * @dataProvider validConfigurations
     *
     * @param array      $configuration
     * @param array|null $expectedProcessedConfiguration
     */
    public function testValidConfiguration(array $configuration, array $expectedProcessedConfiguration = null)
    {
        $this->assertConfigurationIsValid(array('styleci' => $configuration));

        // Set default expected configuration
        $expectedProcessedConfiguration = array_merge(array(
            'linting'  => true,
            'enabled'  => array(),
            'disabled' => array(),
            'risky'    => true,
        ), $expectedProcessedConfiguration ?: $configuration);

        if (isset($configuration['finder'])) {
            $expectedFinderProcessedConfiguration = array_merge_recursive(array(
                'exclude'      => array(),
                'name'         => array(),
                'not_name'     => array(),
                'contains'     => array(),
                'not_contains' => array(),
                'path'         => array(),
                'not_path'     => array(),
                'depth'        => array(),
            ), !empty($expectedProcessedConfiguration) && isset($expectedProcessedConfiguration['finder'])
                ? $expectedProcessedConfiguration['finder']
                : $configuration['finder']
            );

            $expectedProcessedConfiguration['finder'] = $expectedFinderProcessedConfiguration;
        }

        $this->assertProcessedConfigurationEquals(array('styleci' => $configuration), $expectedProcessedConfiguration);
    }

    public function validConfigurations()
    {
        return array(
            array(
                array(
                    'preset' => 'psr1',
                ),
            ),
            array(
                array(
                    'preset' => 'psr2',
                ),
            ),
            array(
                array(
                    'preset' => 'symfony',
                ),
            ),
            array(
                array(
                    'preset' => 'laravel',
                ),
            ),
            array(
                array(
                    'preset' => 'recommended',
                ),
            ),
            array(
                array(
                    'preset'   => 'symfony',
                    'linting'  => false,
                    'enabled'  => array(
                        'return',
                        'phpdoc_params',
                    ),
                    'disabled' => array(
                        'short_array_syntax',
                    ),
                    'finder'   => array(
                        'not_name' => array('*.dummy'),
                    ),
                ),
            ),
            array(
                array(
                    'preset'  => 'symfony',
                    'finder'  => array(
                        'not-name' => array('*.dummy'),
                    ),
                ),
                array(
                    'preset'  => 'symfony',
                    'finder'  => array(
                        'not_name' => array('*.dummy'),
                    ),
                ),
            ),
            array(
                array(
                    'preset'   => 'symfony',
                    'enabled'  => array(
                        'align_double_arrow',
                    ),
                    'disabled' => array(
                        'unalign_double_arrow',
                    ),
                ),
            ),
            // Scalar values
            array(
                array(
                    'preset'   => 'symfony',
                    'enabled'  => 'return',
                    'disabled' => 'long_array_syntax',
                    'finder'   => array(
                        'exclude'      => 'foo',
                        'name'         => 'foo',
                        'not_name'     => 'foo',
                        'contains'     => 'foo',
                        'not_contains' => 'foo',
                        'path'         => 'foo',
                        'not_path'     => 'foo',
                        'depth'        => 'foo',
                    ),
                ),
                array(
                    'preset'   => 'symfony',
                    'enabled'  => array('return'),
                    'disabled' => array('long_array_syntax'),
                    'finder'   => array(
                        'exclude'      => array('foo'),
                        'name'         => array('foo'),
                        'not_name'     => array('foo'),
                        'contains'     => array('foo'),
                        'not_contains' => array('foo'),
                        'path'         => array('foo'),
                        'not_path'     => array('foo'),
                        'depth'        => array('foo'),
                    ),
                ),
            ),
        );
    }

    /**
     * @dataProvider invalidConfigurations
     *
     * @param array $configuration
     */
    public function testInvalidConfiguration(array $configuration)
    {
        $this->assertConfigurationIsInvalid(array('styleci' => $configuration));
    }

    public function invalidConfigurations()
    {
        return array(
            array(
                array(),
            ),
            array(
                array(
                    'preset' => 'dummy',
                ),
            ),
            array(
                array(
                    'preset'  => 'symfony',
                    'linting' => 42,
                ),
            ),
            array(
                array(
                    'preset'  => 'symfony',
                    'linting' => false,
                    'enabled' => false,
                ),
            ),
            array(
                array(
                    'preset'   => 'symfony',
                    'disabled' => false,
                ),
            ),
            array(
                array(
                    'preset'  => 'symfony',
                    'enabled' => array(
                        'dummy',
                        'phpdoc_params',
                    ),
                ),
            ),
            array(
                array(
                    'preset'   => 'symfony',
                    'disabled' => array(
                        'dummy',
                        'short_array_syntax',
                    ),
                ),
            ),
            array(
                array(
                    'preset' => 'symfony',
                    'finder' => array(
                        'not-existing-method' => array('*.dummy'),
                    ),
                ),
            ),
            array(
                array(
                    'preset'  => 'symfony',
                    'enabled' => array(
                        'align_double_arrow',
                    ),
                ),
            ),
            array(
                array(
                    'preset'  => 'psr1',
                    'enabled' => array(
                        'no_blank_lines_before_namespace',
                        'single_blank_line_before_namespace',
                    ),
                ),
            ),
        );
    }
}
