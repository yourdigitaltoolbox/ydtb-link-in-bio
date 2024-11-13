<?php

namespace YDTBLIB\Views\Components\Tabs;

use YDTBLIB\Views\Components\Fields\CheckboxField;
use YDTBLIB\Views\Components\Fields\StringField;
use YDTBLIB\Views\Components\Fields\DropdownField;

/**
 * Compatibility integration admin tab
 *
 * @since BuddyBoss 1.1.5
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Setup Compatibility integration admin tab class.
 *
 * @since BuddyBoss 1.1.5
 */
class BuddyBossAdminTab extends \BP_Admin_Integration_tab
{
    private $fields = [];
    public function initialize()
    {
        $this->tab_order = 60;
        $this->setup_fields();
    }

    public function is_active()
    {
        return true;
    }

    private function setup_fields()
    {
        $this->fields = [
            new CheckboxField(
                'ydtblib_field',
                __('Available To Members', 'ydtb-link-in-bio'),
                __('Check this box to make the link available to members.', 'ydtb-link-in-bio')
            ),
            new DropdownField(
                'ydtblib_dropdown',
                __('Select an Option', 'ydtb-link-in-bio'),
                __('Choose an option from the dropdown.', 'ydtb-link-in-bio'),
                [
                    'option1' => __('Option 1', 'ydtb-link-in-bio'),
                    'option2' => __('Option 2', 'ydtb-link-in-bio'),
                    'option3' => __('Option 3', 'ydtb-link-in-bio'),
                ],
                'option1'
            ),
            new StringField(
                'ydtblib_string',
                __('Enter a String', 'ydtb-link-in-bio'),
                __('Provide a string value.', 'ydtb-link-in-bio'),
                'default value'
            ),
        ];
    }

    public function get_settings_sections()
    {
        $settings = array(
            'ydtblib_settings_section' => array(
                'page' => 'addon',
                'title' => __('Member Link-In-Bio Settings', 'ydtb-link-in-bio'),
            ),
        );

        return (array) apply_filters('get_settings_sections', $settings);
    }

    public function get_settings_fields()
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fields['ydtblib_settings_section'][$field->get_id()] = $field->render();
        }

        return (array) apply_filters('ydtblib_get_settings_fields', $fields);
    }

    public function get_settings_fields_for_section($section_id = '')
    {

        // Bail if section is empty
        if (empty($section_id)) {
            return false;
        }

        $fields = $this->get_settings_fields();
        $retval = isset($fields[$section_id]) ? $fields[$section_id] : false;

        return (array) apply_filters('get_settings_fields_for_section', $retval, $section_id);
    }

    public function ydtb_link_in_bio_tutorial()
    {
        ?>
        <p style="margin-top: -8px;">
            <a class="button" href="
            <?php
            echo esc_url(
                bp_get_admin_url(
                    add_query_arg(
                        array(
                            'page' => 'abc123',
                            'article' => 'abc123',
                        ),
                        'admin.php'
                    )
                )
            );
            ?>
            "><?php esc_html_e('View Tutorial', 'ydtb-link-in-bio'); ?></a>
        </p>
        <?php
    }

    /**
     * Register setting fields
     */
    public function register_fields()
    {

        $sections = $this->get_settings_sections();

        foreach ((array) $sections as $section_id => $section) {

            // Only add section and fields if section has fields
            $fields = $this->get_settings_fields_for_section($section_id);

            if (empty($fields)) {
                continue;
            }

            $section_title = !empty($section['title']) ? $section['title'] : '';
            $section_callback = !empty($section['callback']) ? $section['callback'] : false;

            // Add the section
            $this->add_section($section_id, $section_title, $section_callback, [$this, 'ydtb_link_in_bio_tutorial']);

            // Loop through fields for this section
            foreach ((array) $fields as $field_id => $field) {
                $field['args'] = isset($field['args']) ? $field['args'] : array();
                if (!empty($field['callback']) && !empty($field['title'])) {
                    $sanitize_callback = isset($field['sanitize_callback']) ? $field['sanitize_callback'] : [];
                    $this->add_field($field_id, $field['title'], $field['callback'], $sanitize_callback, $field['args']);
                }
            }
        }
    }
}
