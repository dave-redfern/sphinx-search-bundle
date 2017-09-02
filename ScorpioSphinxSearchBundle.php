<?php

/*
 * This file is part of the Scorpio Sphinx-Search package.
 *
 * (c) Dave Redfern <info@somnambulist.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scorpio\SphinxSearchBundle;

use Scorpio\SphinxSearchBundle\DependencyInjection\Compiler\SearchIndexCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ScorpioSphinxSearchBundle
 *
 * @package    Scorpio\SphinxSearchBundle
 * @subpackage Scorpio\SphinxSearchBundle\ScorpioSphinxSearchBundle
 * @author     Dave Redfern <info@somnambulist.tech>
 */
class ScorpioSphinxSearchBundle extends Bundle
{

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SearchIndexCompilerPass());
    }
}
