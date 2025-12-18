<?php
/**
 * Core Plugin Class.
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class WPForms_Legal_Footer
{

    /**
     * Instance of the class.
     *
     * @since 1.0.0
     * @var WPForms_Legal_Footer
     */
    private static $instance;

    /**
     * Singleton pattern.
     *
     * @since 1.0.0
     * @return WPForms_Legal_Footer
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof WPForms_Legal_Footer)) {
            self::$instance = new WPForms_Legal_Footer();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->includes();
        $this->init();
    }

    /**
     * Include necessary files.
     *
     * @since 1.0.0
     */
    private function includes()
    {
        require_once WPFORMS_LEGAL_FOOTER_PATH . 'includes/class-admin.php';
        require_once WPFORMS_LEGAL_FOOTER_PATH . 'includes/class-builder.php';
        require_once WPFORMS_LEGAL_FOOTER_PATH . 'includes/class-frontend.php';
    }

    /**
     * Initialize the plugin classes.
     *
     * @since 1.0.0
     */
    private function init()
    {
        new WPForms_Legal_Footer_Admin();
        new WPForms_Legal_Footer_Builder();
        new WPForms_Legal_Footer_Frontend();
    }
}
