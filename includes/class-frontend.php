<?php
/**
 * Frontend Rendering Class.
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class WPForms_Legal_Footer_Frontend
{

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // This hook fires right after the submit button.
        add_action('wpforms_display_submit_after', array($this, 'render_footer'), 10, 2);
    }

    /**
     * Render the legal footer.
     *
     * @since 1.0.0
     * @param array $form_data Form data and settings.
     * @param mixed $submit Not used directly usually, but part of hook.
     */
    public function render_footer($form_data, $submit)
    {
        // Check if enabled.
        if (empty($form_data['settings']['legal_footer_enable'])) {
            return;
        }

        $text = !empty($form_data['settings']['legal_footer_text']) ? $form_data['settings']['legal_footer_text'] : '';
        $url = !empty($form_data['settings']['legal_footer_url']) ? $form_data['settings']['legal_footer_url'] : '#';
        $target = !empty($form_data['settings']['legal_footer_target']) ? '_blank' : '_self';

        // Style settings.
        $color = !empty($form_data['settings']['legal_footer_color']) ? $form_data['settings']['legal_footer_color'] : 'inherit';
        $size = !empty($form_data['settings']['legal_footer_size']) ? $form_data['settings']['legal_footer_size'] . 'px' : 'inherit';
        $align = !empty($form_data['settings']['legal_footer_align']) ? $form_data['settings']['legal_footer_align'] : 'left';

        // Generate inline styles.
        $style = sprintf(
            'color: %s; font-size: %s; text-align: %s; display: block; margin-top: 10px;',
            esc_attr($color),
            esc_attr($size),
            esc_attr($align)
        );

        if (empty($text)) {
            return;
        }

        // Security: Allow <a> tags.
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'target' => array(),
                'rel' => array(),
                'style' => array(),
            ),
        );

        // Prepare output.
        $output = sprintf(
            '<div class="wpforms-legal-footer-container" style="%s"><a href="%s" target="%s" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">%s</a></div>',
            $style,
            esc_url($url),
            esc_attr($target),
            esc_html($text)
        );

        // Output securely.
        echo wp_kses($output, array_merge(wp_kses_allowed_html('post'), array('div' => array('style' => array(), 'class' => array()))));
    }
}
