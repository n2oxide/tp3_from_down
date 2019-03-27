<?php
return array(
    //'配置项'=>'配置值'
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        'user$' => array('User/index', '', array('method' => 'get')),
        'user/:id\d$' => array('User/read', '', array('method' => 'get')),
        'user/create$' => array('User/create', '', array('method' => 'get')),
        'user/save$' => array('User/save', '', array('method' => 'post')),
        'user/:id\d/edit$' => array('User/edit', '', array('method' => 'get')),
        'user/update$' => array('User/update', '', array('method' => 'post')),
        'user/:id\d/delete$' => array('User/delete')
    ),
);