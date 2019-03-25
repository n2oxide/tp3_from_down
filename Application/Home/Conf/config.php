<?php
return array(
    //'配置项'=>'配置值'
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        'user/:id\d$' => array('User/read', '', array('method' => 'get')),
        'user/create$' => array('User/create', '', array('method' => 'get')),
        'user/save$' => array('User/save', '', array('method' => 'post')),
    ),
);