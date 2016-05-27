<?php

namespace SLLH\StyleCIFixers\Tests;

use SLLH\StyleCIFixers\Fixers;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class FixersTest extends \PHPUnit_Framework_TestCase
{
    public function testNotEmptyProperties()
    {
        $properties = array(
            'valid',
            'risky',
            'aliases',
            'conflicts',
            'psr1_fixers',
            'psr2_fixers',
            'symfony_fixers',
            'laravel_fixers',
            'recommended_fixers',
        );

        foreach ($properties as $property) {
            $this->assertNotEmpty(Fixers::$$property, 'Fixers::$'.$property.' property should not be empty.');
        }
    }

    public function testGetPresets()
    {
        foreach (Fixers::getPresets() as $preset => $fixers) {
            $property = $preset.'_fixers';
            $this->assertSame($fixers, Fixers::$$property, 'Preset "'.$preset.'" is not the same as property.');
        }
    }

    public function testAliasesNotInValid()
    {
        foreach (array_keys(Fixers::$aliases) as $alias) {
            $this->assertNotContains($alias, Fixers::$valid, 'Alias "'.$alias.'" should not be on Fixers::$valid property.');
        }
    }
}
