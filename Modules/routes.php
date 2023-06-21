<?php

$rules = 
[
    '/^$/' => 
    [
        'controller' => 'Main',
        'action' => 'list',
        'params' => NULL,
    ],

    '/^login\/vgsv$/' => 
    [
        'controller' => 'Login',
        'action' => 'vgsvLogin',
        'params' => NULL,
    ],

    '/^login\/admin$/' => 
    [
        'controller' => 'Login',
        'action' => 'adminLogin',
        'params' => NULL,
    ],

    '/^accidentslist$/' => 
    [
        'controller' => 'Admin',
        'action' => 'getAccidentsList',
        'params' => NULL,
    ],

    '/^vgsv\/(\d+)\/newchange$/' => 
    [
        'controller' => 'Vgsv',
        'action' => 'newChange',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/change_already_on$/' => 
    [
        'controller' => 'Vgsv',
        'action' => 'changeAlreadyOn',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/endchange$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'endChange',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/updateinfo$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'itemUpdate',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'item',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/allchanges$/' =>
    [
        'controller' => 'Change',
        'action' => 'getAll',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/successalert$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'haveSuccessAlert',
        'params' => ['vgsvId'],
    ],

    '/^vgsv\/(\d+)\/changepassword$/' => 
    [
        'controller' => 'Vgsv',
        'action' => 'changePassword',
        'params' => ['vgsvId'],
    ],

    '/^admin\/(\d+)\/changepassword$/' => 
    [
        'controller' => 'Admin',
        'action' => 'changePassword',
        'params' => ['adminId'],
    ],

    '/^vgsv\/(\d+)\/change\/(\d+)$/' =>
    [
        'controller' => 'Change',
        'action' => 'item',
        'params' => ['vgsvId', 'changeId'],
    ],

    '/^vgsv\/(\d+)\/change\/(\d+)\/updateinfo$/' =>
    [
        'controller' => 'Change',
        'action' => 'updateMainInfo',
        'params' => ['vgsvId', 'changeId'],
    ],

    '/^vgsv\/(\d+)\/change\/(\d+)\/deleteinfo$/' =>
    [
        'controller' => 'Change',
        'action' => 'delete',
        'params' => ['vgsvId', 'changeId'],
    ],

    '/^logout$/' =>
    [
        'controller' => 'Login',
        'action' => 'logout',
        'params' => NULL,
    ],

    '/^login\/hub$/' =>
    [
        'controller' => 'Login',
        'action' => 'hub',
        'params' => NULL,
    ],

    '/^accident\/(\d+)$/' =>
    [
        'controller' => 'Accident',
        'action' => 'item',
        'params' => ['accidentId'],
    ],

    '/^admin\/(\d+)\/accident\/(\d+)\/liquidate$/' =>
    [
        'controller' => 'Admin',
        'action' => 'liquidateAccident',
        'params' => ['adminId', 'accidentId'],
    ],

    '/^admin\/(\d+)\/accident\/(\d+)\/confirm$/' =>
    [
        'controller' => 'Admin',
        'action' => 'confirmAccident',
        'params' => ['adminId', 'accidentId'],
    ],

    '/^vgsv\/(\d+)\/accident\/(\d+)\/havealert$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'haveAlert',
        'params' => ['vgsvId', 'accidentId'],
    ],

    '/^vgsv\/(\d+)\/accident\/(\d+)\/departure$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'departure',
        'params' => ['vgsvId', 'accidentId'],
    ],

    '/^vgsv\/(\d+)\/accident\/(\d+)\/change\/(\d+)\/add$/' =>
    [
        'controller' => 'Vgsv',
        'action' => 'addChangeToAccident',
        'params' => ['vgsvId', 'accidentId', 'changeId'],
    ],

    '/^getMainData$/' => 
    [
        'controller' => 'Main',
        'action' => 'getMainData',
        'params' => NULL,
    ],
    
    '/^getAccidentInfo$/' => 
    [
        'controller' => 'Main',
        'action' => 'getAccidentInfo',
        'params' => NULL,
    ],
]

?>