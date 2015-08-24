<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

/*
$collection->add('aw_homepage', new Route('/hello/{name}', array(
    '_controller' => 'AWBundle:Default:index',
))); */

$collection->add('aw_index', new Route('/AW', array(
    '_controller' => 'AWBundle:AW:index',
)));

$collection->add('aw_createUser', new Route('/createUser', array(
    '_controller' => 'AWBundle:AW:createUser',
)));

$collection->add('aw_user_success', new Route('/AW/userSuccess', array(
    '_controller' => 'AWBundle:AW:userSuccess',
)));

$collection->add('show_user', new Route('/AW/showUser', array(
    '_controller' => 'AWBundle:AW:showUser',
)));

$collection->add('show_aw', new Route('/AW/showAw', array(
    '_controller' => 'AWBundle:AW:showAw',
)));
$collection->add('create_aw', new Route('/AW/createAw', array(
    '_controller' => 'AWBundle:AW:createAw',
)));



return $collection;
