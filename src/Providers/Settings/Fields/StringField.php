<?php
namespace YDTBLIB\Providers\Settings\Fields;

use YDTBLIB\Interfaces\SettingsFieldInterface;

class StringField implements SettingsFieldInterface
{
    private $id;
    private $title;
    private $description;
    private $default;

    public function __construct($id, $title, $description = '', $default = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->default = $default;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_title()
    {
        return $this->title;
    }

    public function render()
    {
        return array(
            'title' => __($this->title, 'ydtb-link-in-bio'),
            'callback' => [$this, 'settings_display_callback'],
            'sanitize_callback' => [$this, 'sanitize'],
            'args' => array(),
        );
    }

    public function settings_display_callback()
    {
        $value = $this->get_value();
        ?>
        <input name="<?php echo esc_attr($this->id); ?>"
               id="<?php echo esc_attr($this->id); ?>"
               type="text"
               value="<?php echo esc_attr($value); ?>"
               style="min-width: 50%;"
        />
        <p class="description">
            <?php echo esc_html($this->description); ?>
        </p>
        <?php
}

    public function sanitize($value)
    {
        return sanitize_text_field($value);
    }

    public function get_value()
    {
        $value = get_option($this->id, $this->default);
        return apply_filters("ydtblib_{$this->id}_value", $value);
    }
}