<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('hello','Hello::test');
// $routes->get('evcontacts','Evcontacts::conpage');
// $routes->post('evcontacts/contact', 'Evcontacts::contact');

 $routes->get('admin','Admin::admin_login');

$routes->group('api', function($routes) 
{
    $routes->get('admin_login','Admin::admin_login');
    $routes->post('contact','Admin::contact');
    $routes->get('contact_view','Admin::contact_view');
    $routes->get('contact_view','Admin::contact_view');
    $routes->get('add_courses','Courses::add_courses');
    $routes->get('courses_view','Courses::courses_view');
    $routes->get('delete_courses','Courses::delete_courses'); 
    $routes->get('delete_contact', 'Admin::delete_contact');
    $routes->get('get_courses_by_id', 'Admin::get_courses_by_id');    
    $routes->get('get_courses_by_slug', 'Admin::get_courses_by_slug');  
    $routes->put('get_courses_by_id_update', 'Admin::get_courses_by_id_update');
    $routes->get('add_review', 'Admin::add_review');
    $routes->get('review_view', 'Admin::review_view');
    // $routers->get('delete_review', 'Admin::delete_review'); 
    $routes->post('add_blog', 'Admin::add_blog');
    $routes->get('view_blog', 'Admin::view_blog');
    $routes->get('delete_blog', 'Admin::delete_blog');
    $routes->post('add_services', 'Admin::add_services');
    $routes->get('view_services', 'Admin::view_services');
    $routes->get('delete_services', 'Admin::delete_services');
    $routes->get('pdf_download', 'Admin::pdf_download');
    $routes->get('delete_review', 'Admin::delete_review');
    $routes->get('contact_for_pdf', 'Admin::contact_for_pdf');
});