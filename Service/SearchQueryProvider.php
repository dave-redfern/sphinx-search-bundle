<?php

/*
 * This file is part of the Scorpio SphinxSearch Bundle.
 *
 * (c) Dave Redfern <dave@scorpioframework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scorpio\SphinxSearchBundle\Service;

use Scorpio\SphinxSearch\SearchQuery;

/**
 * Class SearchQueryProvider
 *
 * Container for any mapped query instances configured via the scorpio_sphinx_search.index
 * allowing easier access to the queries.
 *
 * @package    Scorpio\SphinxSearchBundle\Service
 * @subpackage Scorpio\SphinxSearchBundle\Service\SearchQueryProvider
 * @author     Dave Redfern <dave@scorpioframework.com>
 */
class SearchQueryProvider implements \IteratorAggregate, \Countable
{

    /**
     * @var array
     */
    private $queries = [];



    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->queries);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->queries);
    }



    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @param SearchQuery $query
     *
     * @return $this
     */
    public function addQuery(SearchQuery $query)
    {
        $this->queries[$query->getIndex()->getIndexName()] = $query;

        return $this;
    }

    /**
     * @param string $indexName
     *
     * @return null
     */
    public function getQuery($indexName)
    {
        if ( array_key_exists($indexName, $this->queries) ) {
            return $this->queries[$indexName];
        }

        return null;
    }

    /**
     * @param string $indexName
     *
     * @return boolean
     */
    public function hasQuery($indexName)
    {
        return array_key_exists($indexName, $this->queries);
    }

    /**
     * @param string $indexName
     *
     * @return $this
     */
    public function removeQuery($indexName)
    {
        unset($this->queries[$indexName]);

        return $this;
    }

    /**
     * @param array $queries
     *
     * @return $this
     */
    public function setQueries(array $queries)
    {
        $this->queries = $queries;

        return $this;
    }
}