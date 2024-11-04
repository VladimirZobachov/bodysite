<?php

class shopOrdercallPlugin extends shopPlugin
{
    public function __construct($info)
    {
        parent::__construct($info);
    }

    // Render the Order Call button and load the form HTML template
    public function frontendHeader()
    {
        // Check if the plugin is enabled
        if (!$this->getSettings('enabled')) {
            return ''; // Plugin is disabled; do not display anything
        }

        // Get settings
        $link_text = $this->getSettings('link_text');
        $agreement_link = $this->getSettings('agreement_link');

        // Include CSS and JavaScript
        $html = '<link rel="stylesheet" href="' . wa()->getAppStaticUrl('shop') . 'plugins/ordercall/css/ordercall.css">';
        $html .= '<script src="' . wa()->getAppStaticUrl('shop') . 'plugins/ordercall/js/ordercall.js"></script>';

        // Add Order Call button
        $html .= '<button class="order-call-button" onclick="openOrderCallForm()">' . htmlspecialchars($link_text) . '</button>';

        // Load the form HTML template and insert agreement link
        $template_path = wa()->getAppPath('plugins/ordercall/templates/form.html', 'shop');
        $form_html = file_get_contents($template_path);
        $form_html = str_replace('{agreement_link}', htmlspecialchars($agreement_link), $form_html); // Insert agreement link
        $html .= $form_html;

        return $html;
    }

    // Handle the AJAX form submission
    public function ajaxOrderCall()
    {
        $name = waRequest::post('name', '', 'string');
        $phone = waRequest::post('phone', '', 'string');
        $email = waRequest::post('email', '', 'string');
        $time = waRequest::post('time', '', 'string');

        if ($name && $phone && $email && $time) {
            $model = new waModel();
            $model->exec("INSERT INTO `shop_ordercall_requests` (name, phone, email, time) VALUES (s:name, s:phone, s:email, s:time)", [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'time' => $time,
            ]);

            // Send email notification to administrator
            $this->sendAdminNotification($name, $phone, $email, $time);

            return json_encode(['status' => 'success', 'message' => 'Your request has been received']);
        }

        return json_encode(['status' => 'error', 'message' => 'All fields are required']);
    }

    // Send email to the administrator with the request details
    private function sendAdminNotification($name, $phone, $email, $time)
    {
        // Retrieve settings
        $admin_email = $this->getSettings('admin_email');
        $sender_email = $this->getSettings('sender_email');

        $subject = 'New Call Request from ' . $name;
        $message = "
            You have received a new call-back request from a customer. Here are the details:\n\n
            Name: $name\n
            Phone: $phone\n
            Email: $email\n
            Preferred Call Time: $time\n
        ";

        // Configure and send the email
        $mailer = new waMailMessage($subject, $message);
        $mailer->setTo($admin_email);
        $mailer->setFrom($sender_email);
        $mailer->send();
    }
}



