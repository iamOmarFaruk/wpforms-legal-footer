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

        // Link Text.
        wpforms_panel_field(
            'text',
            'settings',
            'legal_footer_text',
            $instance->form_data,
            esc_html__('Link Text', 'wpforms-legal-footer'),
            array(
                'default' => esc_html__('Terms and Conditions', 'wpforms-legal-footer'),
            )
        );

        // Link URL.
        wpforms_panel_field(
            'text',
            'settings',
            'legal_footer_url',
            $instance->form_data,
            esc_html__('Link URL', 'wpforms-legal-footer'),
            array(
                'placeholder' => 'https://example.com/terms',
            )
        );

        // Open in New Tab.
        wpforms_panel_field(
            'checkbox',
            'settings',
            'legal_footer_target',
            $instance->form_data,
            esc_html__('Open in New Tab', 'wpforms-legal-footer')
        );

        // Visual Styles Heading.
        echo '<h3>' . esc_html__('Visual Styles', 'wpforms-legal-footer') . '</h3>';

        // Text Color.
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
                'default' => '14',
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

        echo '</div>';
    }
}
