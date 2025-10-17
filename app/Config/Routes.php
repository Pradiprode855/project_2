<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('hello','Hello::test');
$routes->get('evcontacts','Evcontacts::conpage');
$routes->post('evcontacts/contact', 'Evcontacts::contact');
