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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class ScorpioSphinxSearchExtension
 *
 * @package    Scorpio\SphinxSearchBundle\DependencyInjection
 * @subpackage Scorpio\SphinxSearchBundle\DependencyInjection\ScorpioSphinxSearchExtension
 * @author     Dave Redfern <dave@scorpioframework.com>
 */
class ScorpioSphinxSearchExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $definition = $container->getDefinition('scorpio_sphinx_search.server.settings');
        $definition->setArguments([
            $config['host'], $config['port'], $config['max_query_time'], $config['client_class']
        ]);

        $container->setParameter('scorpio_sphinx_search.host', $config['host']);
        $container->setParameter('scorpio_sphinx_search.port', $config['port']);
    }
}
