<?php
return array(
    'active'  => array(
        'title'        => _w('Plugin Status'),
        'description'  => _w('To display the plugin, insert the code {shopOrdercallViewHelper::display()} into the theme template'),
        'value'        => _w('Order a callback'),
        'options'      => array(
            array(
                "value" => "0",
                "title" => _w("Disabled"),
            ),
            array(
                "value" => "1",
                "title" => _w("Enabled"),
            ),
        ),
        'control_type' => waHtmlControl::SELECT,
    ),
    'link_name'  => array(
        'title'        => _w('Link Text'),
        'description'  => _w('Specify the link text for the frontend'),
        'value'        => _w('Order a callback'),
        'control_type' => waHtmlControl::INPUT,
    ),
    'email_from'  => array(
        'title'        => _w('Sender Email'),
        'description'  => _w('Specify the sender\'s email'),
        'value'        => 'no-reply@' . ($main_site_domain = wa()->getRouting()->getDomain()),
        'control_type' => waHtmlControl::INPUT,
    ),
    'email_to'  => array(
        'title'        => _w('Recipient Email'),
        'description'  => _w('Specify the email to send callback requests to'),
        'value'        => wa('shop')->getConfig()->getGeneralSettings('email'),
        'control_type' => waHtmlControl::INPUT,
    ),
    'agree_check'  => array(
        'title'        => _w('Display Agreement with Policy'),
        'value'        => '0',
        'control_type' => waHtmlControl::CHECKBOX,
    ),
    'agree_link'  => array(
        'title'        => _w('Link to Policy Page'),
        'description'  => _w('Specify the link to the page with the privacy policy'),
        'value'        => '/sample/',
        'control_type' => waHtmlControl::INPUT,
    ),
    'subject'  => array(
        'title'        => _w('Email Subject'),
        'description'  => _w('Specify the email subject for the admin'),
        'value'        => _w('Callback request from the site'),
        'control_type' => waHtmlControl::INPUT,
    ),
    'subject_url'  => array(
        'title'        => _w('Website Address'),
        'description'  => _w('Specify whether to include the website address in the email subject'),
        'value'        => '1',
        'control_type' => waHtmlControl::CHECKBOX,
    ),
    'captcha'  => array(
        'title'        => _w('Display Captcha'),
        'description'  => _w('Specify whether to add captcha to the form'),
        'value'        => '0',
        'control_type' => waHtmlControl::CHECKBOX,
    ),
);

