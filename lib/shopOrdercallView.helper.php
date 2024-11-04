<?php

class ShopOrderCallViewHelper extends ShopOrderCallPlugin
{
    /**
     * Renders the order call form link if the plugin is active.
     *
     * @return string|false HTML content of the order call link or false if inactive.
     */
    public static function display()
    {
        if (!self::isPluginActive()) {
            return false;
        }

        $view = wa()->getView();
        $plugin = wa('shop')->getPlugin(self::PLUGIN_ID);

        $view->assign([
            'headerText' => _w('Order a Callback'),
            'headerInfoText' => _w('Leave your contact details and we will call you back'),
            'contactInfoText' => _w('Contact Information'),
            'nameLabel' => _w('Name'),
            'phoneLabel' => _w('Phone'),
            'callTimeLabel' => _w('Preferred Call Time'),
            'commentLabel' => _w('Comment'),
            'captchaError' => _w('Incorrect Captcha entered'),
            'agreeText' => _w('I agree to the processing of '),
            'personalDataLinkText' => _w('personal data'),
            'submitButtonText' => _w('Order'),
        ]);

        // Assign plugin settings to the view
        $view->assign([
            'link' => $plugin->getSettings('agree_link'),
            'captcha' => $plugin->getSettings('captcha'),
            'agree' => $plugin->getSettings('agree_check')
        ]);

        // Build the file path for the HTML template
        $templatePath = self::getTemplatePath();

        // Render the template content and append the order call link
        $content = $view->fetch($templatePath);
        $linkName = $plugin->getSettings('link_name');

        return $content . self::generateOrderCallLink($linkName);
    }

    /**
     * Checks if the plugin is active based on its settings.
     *
     * @return bool
     */
    private static function isPluginActive(): bool
    {
        return (bool) wa('shop')->getPlugin(self::PLUGIN_ID)->getSettings('active');
    }

    /**
     * Constructs the path to the template file.
     *
     * @return string Path to the order call form template.
     */
    private static function getTemplatePath(): string
    {
        return wa()->getAppPath(null, 'shop') . '/plugins/' . self::PLUGIN_ID . '/templates/actions/frontend/Form.html';
    }

    /**
     * Generates the HTML for the order call link.
     *
     * @param string $linkName Name of the link to be displayed.
     * @return string HTML anchor tag with the order call link.
     */
    private static function generateOrderCallLink(string $linkName): string
    {
        return '<a href="#" onclick="return false;" class="ordercallink">' . htmlspecialchars($linkName) . '</a>';
    }
}
