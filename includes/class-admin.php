<?php
/**
 * Admin Class.
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class WPForms_Legal_Footer_Admin
{

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'check_dependencies'));
        add_action('admin_notices', array($this, 'dependency_notice'));
    }

    /**
     * Check if WPForms is active.
     *
     * @since 1.0.0
     */
    public function check_dependencies()
    {
        if (!class_exists('WPForms')) {
            // We can't really do anything else here other than rely on the notice.
            // Maybe deactivate self to prevent errors? For now, we just warn.
        }
    }

    /**
     * Display a notice if WPForms is not active.
     *
     * @since 1.0.0
     */
    public function dependency_notice()
    {
        if (class_exists('WPForms')) {
            return;
        }
        ?>
        <div class="notice notice-error">
            <p>
                <?php
                printf(
                    /* translators: %s: Plugin Name */
                    esc_html__('%1$s requires WPForms to be installed and active. Please install WPForms to use this plugin.', 'wpforms-legal-footer'),
                    '<strong>' . esc_html__('WPForms Legal Footer', 'wpforms-legal-footer') . '</strong>'
                );
                ?>
            </p>
        </div>
        <?php
    }
}
