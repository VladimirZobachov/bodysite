<?php

return array(
    'name' => 'Order Call',
    'description' => 'Allow customers to request a call-back',
    'version' => '1.0.0',
    'vendor' => 'yourname',
    'handlers' => array(
        'frontend_header' => 'frontendHeader',
    ),
    'settings' => array(
        'enabled' => array(
            'title' => 'Enable Plugin',
            'type' => 'checkbox',
            'value' => 1, // Enabled by default
        ),
        'link_text' => array(
            'title' => 'Order Call Link Text',
            'value' => 'Order a Call', // Default button text
            'description' => 'Text to display on the Order Call button',
        ),
        'admin_email' => array(
            'title' => 'Administrator Email',
            'value' => 'admin@example.com', // Default admin email
            'description' => 'Email address to receive call-back requests',
        ),
        'sender_email' => array(
            'title' => 'Sender Email',
            'value' => 'no-reply@example.com', // Default sender email
            'description' => 'Email address that will appear as the sender',
        ),
        'agreement_link' => array(
            'title' => 'Agreement Link',
            'value' => '/terms', // Default agreement URL
            'description' => 'URL to the agreement or terms page',
        ),
    ),
);


