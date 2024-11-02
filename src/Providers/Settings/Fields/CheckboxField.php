<?php
namespace YDTBLIB\Providers\Settings\Fields;

use YDTBLIB\Interfaces\SettingsFieldInterface;

class CheckboxField implements SettingsFieldInterface
{
    private $id;
    private $title;
    private $description;
    private $default;

    public function __construct($id, $title, $description = '', $default = 0)
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
               type="checkbox"
               value="1" <?php checked($value, 1);?>
        />
        <label for="<?php echo esc_attr($this->id); ?>">
            <?php echo esc_html($this->title); ?>
        </label>
        <p class="description">
            <?php echo esc_html($this->description); ?>
        </p>
        <?php
}

    public function sanitize($value)
    {
        return absint($value);
    }

    public function get_value()
    {
        $value = get_option($this->id, $this->default);
        return apply_filters("ydtblib_{$this->id}_value", $value);
    }
}
