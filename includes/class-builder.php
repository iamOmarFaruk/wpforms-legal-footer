<?php
/**
 * Form Builder Class.
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class WPForms_Legal_Footer_Builder
{

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // Hook into the Settings tab of the Form Builder.
        add_filter('wpforms_builder_settings_sections', array($this, 'register_settings_section'), 20, 2);
        add_action('wpforms_form_settings_panel_content', array($this, 'output_settings_content'), 20, 1);
        add_action('wpforms_builder_enqueues', array($this, 'enqueue_assets'));
    }

    /**
     * Enqueue assets for the builder.
     * 
     * @since 1.0.0
     */
    public function enqueue_assets()
    {
        wp_enqueue_script(
            'wpforms-legal-footer-builder',
            WPFORMS_LEGAL_FOOTER_URL . 'assets/js/admin-builder.js',
            array('jquery'),
            WPFORMS_LEGAL_FOOTER_VERSION,
            true
        );

        wp_enqueue_style(
            'wpforms-legal-footer-builder',
            WPFORMS_LEGAL_FOOTER_URL . 'assets/css/admin-builder.css',
            array(),
            WPFORMS_LEGAL_FOOTER_VERSION
        );
    }

    /**
     * Register the "Legal Footer" section in Form Settings.
     *
     * @since 1.0.0
     * @param array $sections Existing sections.
     * @param array $form_data Form data.
     * @return array Modified sections.
     */
    public function register_settings_section($sections, $form_data)
    {
        $sections['legal_footer'] = esc_html__('Legal Footer', 'wpforms-legal-footer');
        return $sections;
    }

    /**
     * Output the content for the "Legal Footer" section.
     *
     * @since 1.0.0
     * @param object $instance WPForms_Builder_Panel_Settings instance.
     */
    public function output_settings_content($instance)
    {
        echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-legal_footer">';
        echo '<div class="wpforms-panel-content-section-title">';
        esc_html_e('Legal Footer Settings', 'wpforms-legal-footer');
        echo '</div>';

        // Enable Toggle.
        wpforms_panel_field(
            'toggle',
            'settings',
            'legal_footer_enable',
            $instance->form_data,
            esc_html__('Enable Legal Footer', 'wpforms-legal-footer')
        );

        // Container for conditional visibility.
        echo '<div class="wpforms-legal-footer-settings-content">';

        // --- Data Preparation ---
        $pages = get_pages();
        $page_options = array('' => esc_html__('Select a Page', 'wpforms-legal-footer'));

        // Defaults auto-detection
        $privacy_page_id = '';
        $terms_page_id = '';

        foreach ($pages as $page) {
            $page_options[$page->ID] = $page->post_title;

            // Simple text matching for auto-detection
            $title = strtolower($page->post_title);
            if (empty($privacy_page_id) && (strpos($title, 'privacy') !== false)) {
                $privacy_page_id = $page->ID;
            }
            if (empty($terms_page_id) && (strpos($title, 'terms') !== false || strpos($title, 'conditions') !== false)) {
                $terms_page_id = $page->ID;
            }
        }

        // Helper function for rendering a link block.
        $render_link_block = function ($id, $label, $defaults = array ()) use ($instance, $page_options) {
            echo '<div class="wpforms-legal-footer-block">';
            echo '<h4>' . esc_html($label) . '</h4>';

            // Link Label
            wpforms_panel_field(
                'text',
                'settings',
                "legal_footer_{$id}_label",
                $instance->form_data,
                esc_html__('Label Text', 'wpforms-legal-footer'),
                array(
                    'placeholder' => esc_html__('e.g. Privacy Policy', 'wpforms-legal-footer'),
                    'default' => isset($defaults['label']) ? $defaults['label'] : '',
                )
            );

            // Link Type Selector
            wpforms_panel_field(
                'select',
                'settings',
                "legal_footer_{$id}_type",
                $instance->form_data,
                esc_html__('Link Type', 'wpforms-legal-footer'),
                array(
                    'options' => array(
                        'custom' => esc_html__('Custom URL', 'wpforms-legal-footer'),
                        'page' => esc_html__('WordPress Page', 'wpforms-legal-footer'),
                    ),
                    'class' => 'wpforms-legal-footer-link-type',
                    'data' => array('target' => "legal_footer_{$id}"),
                    'default' => isset($defaults['type']) ? $defaults['type'] : 'custom',
                )
            );

            // Custom URL Input
            echo '<div class="wpforms-legal-footer-input-custom" id="wpforms-legal-footer-' . esc_attr($id) . '-custom">';
            wpforms_panel_field(
                'text',
                'settings',
                "legal_footer_{$id}_url",
                $instance->form_data,
                esc_html__('External URL', 'wpforms-legal-footer'),
                array('placeholder' => 'https://...')
            );
            echo '</div>';

            // Page Selector
            echo '<div class="wpforms-legal-footer-input-page" id="wpforms-legal-footer-' . esc_attr($id) . '-page" style="display:none;">';
            wpforms_panel_field(
                'select',
                'settings',
                "legal_footer_{$id}_page",
                $instance->form_data,
                esc_html__('Select Page', 'wpforms-legal-footer'),
                array(
                    'options' => $page_options,
                    'default' => isset($defaults['page']) ? $defaults['page'] : '',
                )
            );
            echo '</div>';
            echo '</div>';
        };

        // Render Link 1 (Privacy Policy Default)
        $render_link_block('link1', 'Primary Link (Left)', array(
            'label' => 'Privacy Policy',
            'type' => !empty($privacy_page_id) ? 'page' : 'custom',
            'page' => $privacy_page_id,
        ));

        // Render Link 2 (Terms Default)
        $render_link_block('link2', 'Secondary Link (Right)', array(
            'label' => 'Terms and Conditions',
            'type' => !empty($terms_page_id) ? 'page' : 'custom',
            'page' => $terms_page_id,
        ));

        // --- Visual Styles ---
        echo '<div class="wpforms-legal-footer-block">';
        echo '<h3>' . esc_html__('Visual Appearance', 'wpforms-legal-footer') . '</h3>';

        // Open in New Tab
        wpforms_panel_field(
            'checkbox',
            'settings',
            'legal_footer_target',
            $instance->form_data,
            esc_html__('Open Links in New Tab', 'wpforms-legal-footer')
        );

        // Bold Text
        wpforms_panel_field(
            'checkbox',
            'settings',
            'legal_footer_bold',
            $instance->form_data,
            esc_html__('Bold Text', 'wpforms-legal-footer'),
            array('default' => '1') // Checked by default
        );

        // Text Color
        wpforms_panel_field(
            'color',
            'settings',
            'legal_footer_color',
            $instance->form_data,
            esc_html__('Text Color', 'wpforms-legal-footer')
        );

        // Font Size.
        wpforms_panel_field(
            'text',
            'settings',
            'legal_footer_size',
            $instance->form_data,
            esc_html__('Font Size (px)', 'wpforms-legal-footer'),
            array(
                'type' => 'number',
                'default' => '12',
            )
        );

        // Alignment.
        wpforms_panel_field(
            'select',
            'settings',
            'legal_footer_align',
            $instance->form_data,
            esc_html__('Alignment', 'wpforms-legal-footer'),
            array(
                'options' => array(
                    'left' => esc_html__('Left', 'wpforms-legal-footer'),
                    'center' => esc_html__('Center', 'wpforms-legal-footer'),
                    'right' => esc_html__('Right', 'wpforms-legal-footer'),
                ),
                'default' => 'left',
            )
        );
        echo '</div>'; // End visual block

        echo '</div>'; // End conditional container
        echo '</div>'; // End section
    }
}
