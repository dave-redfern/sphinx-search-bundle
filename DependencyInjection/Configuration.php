<?php

/*
 * This file is part of the Scorpio Sphinx-Search package.
 *
 * (c) Dave Redfern <dave@scorpioframework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scorpio\SphinxSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package    Scorpio\SphinxSearchBundle\DependencyInjection
 * @subpackage Scorpio\SphinxSearchBundle\DependencyInjection\Configuration
 * @author     Dave Redfern <dave@scorpioframework.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('scorpio_sphinx_search');

        $rootNode
            ->children()
                ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('port')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('max_query_time')->defaultValue(5000)->end()
                ->scalarNode('client_class')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
