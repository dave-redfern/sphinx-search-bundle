<?php

/*
 * This file is part of the Scorpio SphinxSearch Bundle.
 *
 * (c) Dave Redfern <dave@scorpioframework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scorpio\SphinxSearchBundle\DependencyInjection\Compiler;

use Scorpio\SphinxSearch\SearchQuery;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SearchIndexCompilerPass
 *
 * @package    Scorpio\SphinxSearchBundle\DependencyInjection\Compiler
 * @subpackage Scorpio\SphinxSearchBundle\DependencyInjection\Compiler\SearchIndexCompilerPass
 * @author     Dave Redfern <dave@scorpioframework.com>
 */
class SearchIndexCompilerPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $prefix = 'query';
        if ($container->hasParameter('scorpio_sphinx_search.query_service_prefix')) {
            $prefix = $container->getParameter('scorpio_sphinx_search.query_service_prefix');
            $prefix = rtrim($prefix, '.');
        }

        foreach ($container->findTaggedServiceIds('scorpio_sphinx_search.index') as $id => $attributes) {
            foreach ( $attributes as $key => $value ) {
                if ( $key == 'query' && $value ) {
                    $service = $prefix . '.' . $id;

                    $definition = $container->register($service, SearchQuery::class);
                    $definition->addArgument(new Reference($id));
                }
            }
        }
    }
}