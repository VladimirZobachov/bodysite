<?php

class ShopOrderCallPlugin extends shopPlugin
{
    const PLUGIN_ID = 'ordercall';

    /**
     * Adds necessary CSS and JavaScript files to the frontend if the plugin is active.
     */
    public function frontendHead()
    {
        if ($this->isPluginActive()) {
            $this->enqueueAssets();
        }
    }

    /**
     * Checks if the plugin is active based on its settings.
     *
     * @return bool
     */
    private function isPluginActive(): bool
    {
        return (bool) wa('shop')->getPlugin(self::PLUGIN_ID)->getSettings('active');
    }

    /**
     * Adds CSS and JavaScript files required by the plugin to the frontend.
     */
    private function enqueueAssets(): void
    {
        $this->addCss('css/ordercall.css');
        $this->addCss('css/jquery-ui.css');
        $this->addJs('js/jquery-ui.js');
        $this->addJs('js/jquery.maskedinput.min.js');
        $this->addJs('js/ordercall.js');
    }
}
