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

        $settings = $form_data['settings'];
        $links = array();

        // Helper to process link data
        $process_link = function ($id) use ($settings) {
            $label = isset($settings["legal_footer_{$id}_label"]) ? trim($settings["legal_footer_{$id}_label"]) : '';
            if (empty($label))
                return null;

            $type = isset($settings["legal_footer_{$id}_type"]) ? $settings["legal_footer_{$id}_type"] : 'custom';
            $url = '';

            if ('page' === $type && !empty($settings["legal_footer_{$id}_page"])) {
                $url = get_permalink($settings["legal_footer_{$id}_page"]);
            } else {
                $url = isset($settings["legal_footer_{$id}_url"]) ? $settings["legal_footer_{$id}_url"] : '#';
            }

            return array('label' => $label, 'url' => $url);
        };

        // Get Links
        if ($link1 = $process_link('link1'))
            $links[] = $link1;
        if ($link2 = $process_link('link2'))
            $links[] = $link2;

        if (empty($links)) {
            return;
        }

        // Styles
        $color = !empty($settings['legal_footer_color']) ? $settings['legal_footer_color'] : 'inherit';
        $size = !empty($settings['legal_footer_size']) ? $settings['legal_footer_size'] . 'px' : '12px';
        $align = !empty($settings['legal_footer_align']) ? $settings['legal_footer_align'] : 'left';
        $target = !empty($settings['legal_footer_target']) ? '_blank' : '_self';
        $is_bold = !empty($settings['legal_footer_bold']);

        // Container Styles
        $style = sprintf(
            'color: %s; font-size: %s; text-align: %s; display: block; margin-top: 10px;',
            esc_attr($color),
            esc_attr($size),
            esc_attr($align)
        );

        // Link Styles
        $link_style = 'color: inherit; text-decoration: none;';
        if ($is_bold) {
            $link_style .= ' font-weight: bold;';
        }

        // Security: Allow <a> tags.
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'target' => array(),
                'rel' => array(),
                'style' => array(),
                'class' => array(),
            ),
            'span' => array('class' => array()),
        );

        // Build Output
        $output_links = array();
        foreach ($links as $link) {
            $output_links[] = sprintf(
                '<a href="%s" target="%s" rel="noopener noreferrer" style="%s" class="wpforms-legal-footer-link">%s</a>',
                esc_url($link['url']),
                esc_attr($target),
                esc_attr($link_style),
                esc_html($link['label'])
            );
        }

        // Join with separate if multiple
        $content = implode(' <span class="sep">|</span> ', $output_links);

        // Wrapper
        $html = sprintf(
            '<div class="wpforms-legal-footer-container" style="%s">%s</div>',
            $style,
            $content
        );

        // Add Hover Effect via scoped style block (safe for modern browsers)
        $html .= '<style>.wpforms-legal-footer-link:hover { text-decoration: underline !important; }</style>';

        // Output securely.
        echo wp_kses($html, array_merge(wp_kses_allowed_html('post'), array(
            'div' => array('style' => array(), 'class' => array()),
            'style' => array()
        )));
    }
}
