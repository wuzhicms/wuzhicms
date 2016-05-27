<?php

namespace SLLH\StyleCIBridge\StyleCI;

use SLLH\StyleCIFixers\Fixers;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('styleci');

        $validFixers = array_merge(Fixers::$valid, array_keys(Fixers::$aliases));

        $rootNode
            ->children()
                ->enumNode('preset')
                    ->isRequired()
                    ->values(array_keys(Fixers::getPresets()))
                ->end()
                ->booleanNode('linting')
                    ->defaultTrue()
                ->end()
                ->arrayNode('enabled')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')
                        ->validate()
                            ->ifNotInArray($validFixers)
                            ->thenInvalid('Invalid enabled fixer %s.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('disabled')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')
                        ->validate()
                            ->ifNotInArray($validFixers)
                            ->thenInvalid('Invalid disabled fixer %s.')
                        ->end()
                    ->end()
                ->end()
                ->append($this->getFinderConfigurationNode())
                ->booleanNode('risky')
                    ->defaultTrue()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(function ($config) {
                    $presets = Fixers::getPresets();
                    $enabledFixers = array_merge($presets[$config['preset']], $config['enabled']);
                    $disabledFixers = $config['disabled'];
                    $fixers = array_diff($enabledFixers, $disabledFixers);

                    // See: https://github.com/StyleCI/Config/blob/f9747aba632aa4d272f212b5b9c9942234f4f074/src/Config.php#L549-L553
                    foreach (Fixers::$conflicts as $first => $second) {
                        if (in_array($first, $fixers, true) && in_array($second, $fixers, true)) {
                            return true;
                        }
                    }

                    return false;
                })
                ->thenInvalid('Conflicted fixers. Check conflicts definition.')
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @return ArrayNodeDefinition|NodeDefinition
     */
    private function getFinderConfigurationNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('finder');

        $node
            ->beforeNormalization()
                ->always(function ($v) {
                    foreach ($v as $option => $value) {
                        $v[$option] = (array) $value;
                    }

                    return $v;
                })
            ->end()
            ->children()
                ->arrayNode('exclude')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('not_name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('contains')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('not_contains')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('path')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('not_path')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('depth')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
