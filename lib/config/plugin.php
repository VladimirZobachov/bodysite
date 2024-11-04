<?php
return array(
    'name' => 'Order Callback',
    'img'  => 'img/phone.svg',
    'description' => 'A plugin for callback requests',
    'version' => '1.0',
    'frontend' => true,
    'handlers' => array(
        'frontend_head' => 'frontendHead',
    ),
    'custom_settings' => false,
);
