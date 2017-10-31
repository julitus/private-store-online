<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Stores', 'action' => 'login']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    //$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->connect('/inicio', ['controller' => 'Pages', 'action' => 'dashboard']);

    $routes->connect('/tiendas', ['controller' => 'Stores', 'action' => 'index']);
    $routes->connect('/productos', ['controller' => 'Products', 'action' => 'index']);
    $routes->connect('/almacen', ['controller' => 'Warehouses', 'action' => 'index']);
    $routes->connect('/tienda/a', ['controller' => 'Stores', 'action' => 'add']);
    $routes->connect('/producto/a', ['controller' => 'Products', 'action' => 'add']);
    $routes->connect('/producto/i/a', ['controller' => 'Products', 'action' => 'addItem']);

    $routes->connect(
        '/tienda/:id-:slug', 
        ['controller' => 'Stores', 'action' => 'view'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );
    $routes->connect(
        '/cambiar_mi_clave/:id-:slug', 
        ['controller' => 'Stores', 'action' => 'changePassword'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );
    $routes->connect(
        '/tienda/e/:id-:slug', 
        ['controller' => 'Stores', 'action' => 'edit'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/producto/:id-:slug', 
        ['controller' => 'Products', 'action' => 'view'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );
    $routes->connect(
        '/producto/e/:id-:slug', 
        ['controller' => 'Products', 'action' => 'edit'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );
    $routes->connect(
        '/producto/i/:id-:slug', 
        ['controller' => 'Warehouses', 'action' => 'view'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );
    $routes->connect(
        '/producto/i/e/:id-:slug', 
        ['controller' => 'Warehouses', 'action' => 'edit'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );

    $routes->connect('/categorias', ['controller' => 'Categories', 'action' => 'add']);
    $routes->connect('/paises', ['controller' => 'Countries', 'action' => 'add']);
    $routes->connect('/dptos', ['controller' => 'States', 'action' => 'add']);
    $routes->connect('/ciudades', ['controller' => 'Provinces', 'action' => 'add']);
    $routes->connect('/medidas', ['controller' => 'Measures', 'action' => 'add']);

    $routes->connect(
        '/categoria/e/:id-:slug',
        ['controller' => 'Categories', 'action' => 'edit'], 
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/categoria/:id-:slug',
        ['controller' => 'Categories', 'action' => 'view'], 
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/pais/e/:id',
        ['controller' => 'Countries', 'action' => 'edit'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/pais/:id',
        ['controller' => 'Countries', 'action' => 'view'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/dpto/e/:id',
        ['controller' => 'States', 'action' => 'edit'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/dpto/:id',
        ['controller' => 'States', 'action' => 'view'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/ciudad/e/:id',
        ['controller' => 'Provinces', 'action' => 'edit'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/ciudad/:id',
        ['controller' => 'Provinces', 'action' => 'view'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/medida/e/:id',
        ['controller' => 'Measures', 'action' => 'edit'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    $routes->connect(
        '/medida/:id',
        ['controller' => 'Measures', 'action' => 'view'], 
        ['pass' => ['id'], 'id' => '[0-9]+']
    );

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */

    //$routes->connect('/*', ['controller' => 'Stores', 'action' => 'login']);
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
