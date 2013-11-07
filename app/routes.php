<?php

$router->map('/',
    array(
        'controller'    => 'Controllers\HomeController',
        'action'        => 'loadLanding'
    ),
    array('methods' => 'GET')
);

$router->map('/clients',
    array(
        'controller'    => 'Controllers\ClientController',
        'action'        => 'getClients'
    ),
    array('methods' => 'GET')
);

$router->map('/validateClientName',
    array(
        'controller'    => 'Controllers\ModalController',
        'action'        => 'validateClientName'
    ),
    array('methods' => 'POST')
);

$router->map('/modal',
    array(
        'controller'    => 'Controllers\ModalController',
        'action'        => 'deliverModal'
    ),
    array('methods' => 'GET',
        'name'  => 'modalType'
    )
);

$router->map('/add',
    array(
        'controller'    => 'Controllers\ModalController',
        'action'        => 'add'
    ),
    array('methods' => 'POST')
);

$router->map('/update/:id',
    array(
        'controller'    => 'Controllers\ModalController',
        'action'        => 'update'
    ),
    array(
        'methods' => 'POST',
        'filters' => array('id' => '(\d+)')
    )
);

$router->map('/delete',
    array(
        'controller'    => 'Controllers\ModalController',
        'action'        => 'delete'
    ),
    array('methods' => 'POST')
);