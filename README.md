Scorpio SphinxSearchBundle
==========================

SphinxSearchBundle adds configuration and service support to Scorpio SphinxSearch,
making it easier to use in a Symfony project.

Requirements
------------

 * Symfony 3+
 * Scorpio SphinxSearch
 * for composer installs, PHP Sphinx extension

Installation
------------

 1. The preferred method is to install via composer:

    composer require scorpio/sphinx-search-bundle

 2. Enable the bundle in your AppKernel:

    ```php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Scorpio\SphinxSearchBundle\ScorpioSphinxSearchBundle(),
            // ...
        );
    }
    ```

 3. Set the configuration parameters in your config.yml

 4. Map some indexes (see later)

Basic Usage
-----------

This bundle exposes the following configuration:

```yaml
scorpio_sphinx_search:
    host: localhost
    port: 9312
    max_query_time: 3000 # max query execution time
```

Optionally a specific SphinxClient class can be specified to handle the connections.
This can be used if the PHP extension is not available and the SphinxQL library
cannot be used.

```yaml
scorpio_sphinx_search:
    client_class: SomeClass\That\Implements\SphinxClientAPI
```

The following services are automatically registered:

 * scorpio_sphinx_search.server.settings (private)
 * scorpio_sphinx_search.search_manager  (main search manager instance)

Indexes can be configured as services:

```yaml
services:
    my_custom_sphinx_index:
        class: Scorpio\SphinxSearch\SearchIndex
        arguments:
           - 'my_custom_sphinx_index'
           - [ 'available', 'fields', 'as_an_array' ]
           - [ 'attribute1', 'attribute2' ]
```

Note: the index name and fields are required and must match what is exposed in the
Sphinx configuration.

Additionally the result set and result record class can also be specified:

```yaml
services:
    my_custom_sphinx_index:
        class: Scorpio\SphinxSearch\SearchIndex
        arguments:
           - 'my_custom_sphinx_index'
           - [ 'available', 'fields', 'as_an_array' ]
           - [ 'attribute1', 'attribute2' ]
           - 'MyResultSet'
           - 'MyCustomResult'
```

Finally, for the really lazy!, the index definition can be tagged with the custom
attribute "query" set to true:

```yaml
services:
    my_custom_sphinx_index:
        tags:
            - { name: scorpio_sphinx_search.index, query: true }
```

And a custom query service will be automatically registered in the container. The prefix
can be customised in your parameters.yml, the default if not set is "query", so the
previous tag would create the service: "query.my_custom_sphinx_index".

Note: the attribute "query" must be set to true, otherwise the index will be ignored.
This allows the services to be tagged and locatable for debugging but not auto-create
a query service when not needed.

In your controller you can then access the query instance:

```php
class MyController extends Controller
{

    function indexAction(Request $request)
    {
        // bind a search term somehow, apply filters etc. maybe check for keywords...
        $query = $this
            ->get('query.my_custom_sphinx_index')
            ->setQuery($request->query->get('keywords'));

        $results = $this->get('scorpio_sphinx_search.search_manager')->query($query);

        // do something with the results.
    }
}
```

License
-------

This bundle is licensed under the BSD license. See the complete license in the bundle
LICENSE file.

Issues or feature requests
---------------------------

Issues and feature requests should be made on the [Github repository page](https://github.com/scorpioframework/sphinx-search-bundle/issues).
