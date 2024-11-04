<?php

class ShopOrderCallPluginFrontendSendController extends waController
{
    /**
     * Handles the sending of the order call request email.
     */
    public function execute()
    {
        $plugin = wa('shop')->getPlugin('ordercall');

        // Determine subject URL based on plugin settings
        $url = $plugin->getSettings('subject_url') ? wa()->getRouting()->getDomain() : '';

        // Collect form data
        $name = waRequest::post('name', '');
        $phone = waRequest::post('phone', '');
        $timeFrom = waRequest::post('timefrom', '');
        $timeTo = waRequest::post('timeto', '');
        $comment = waRequest::post('comment', '');

        // Construct the email body with localized text
        $body = sprintf(
            _w('A visitor on the website requested a callback') . '<br><br>' .
            _w('Name: %s') . '<br>' .
            _w('Phone: %s') . '<br>' .
            _w('Preferred call time: from %s to %s') . '<br>' .
            _w('Comment: %s'),
            htmlspecialchars($name),
            htmlspecialchars($phone),
            htmlspecialchars($timeFrom),
            htmlspecialchars($timeTo),
            htmlspecialchars($comment)
        );

        // Create email subject and message
        $subject = $plugin->getSettings('subject') . ' ' . $url;
        $mailMessage = new waMailMessage($subject, $body);
        $mailMessage->setTo($plugin->getSettings('email_to'), '');
        $mailMessage->setFrom($plugin->getSettings('email_from'), '');

        // Validate and send the email
        if ($this->isFormValid($name, $phone)) {
            if ($this->isCaptchaValid($plugin)) {
                $mailMessage->send();
                echo _w("Email sent successfully");
            } else {
                echo _w("Captcha validation failed. Email not sent.");
            }
        } else {
            echo _w("Form validation failed. Email not sent.");
        }
    }

    /**
     * Validates the form by checking required fields.
     *
     * @param string $name
     * @param string $phone
     * @return bool
     */
    private function isFormValid(string $name, string $phone): bool
    {
        return !empty($name) && !empty($phone);
    }

    /**
     * Validates the captcha if enabled in plugin settings.
     *
     * @param waPlugin $plugin
     * @return bool
     */
    private function isCaptchaValid(waPlugin $plugin): bool
    {
        return !$plugin->getSettings('captcha') || wa()->getCaptcha()->isValid();
    }
}
