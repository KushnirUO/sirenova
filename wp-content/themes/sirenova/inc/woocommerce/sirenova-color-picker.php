<?php
// Додавання поля для вибору кольору до атрибутів
add_action('pa_color_add_form_fields', 'add_color_picker_to_attributes');
add_action('pa_color_edit_form_fields', 'edit_color_picker_to_attributes', 10, 2);

function add_color_picker_to_attributes() {
    ?>
    <div class="form-field">
        <label for="attribute_color"><?php esc_html_e('Колір', 'woocommerce'); ?></label>
        <input type="text" name="attribute_color" id="attribute_color" value="" class="my-color-field" data-default-color="#effeff" />
    </div>
    <?php
}

function edit_color_picker_to_attributes($term, $taxonomy) {
    $color = get_term_meta($term->term_id, 'attribute_color', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="attribute_color"><?php esc_html_e('Колір', 'woocommerce'); ?></label>
        </th>
        <td>
            <input type="text" name="attribute_color" id="attribute_color" value="<?php echo esc_attr($color) ? esc_attr($color) : ''; ?>" class="my-color-field" data-default-color="#effeff" />
        </td>
    </tr>
    <?php
}

// Збереження значення кольору при створенні нового терміну
add_action('created_pa_color', 'save_attribute_color', 10, 2);
// Збереження значення кольору при оновленні терміну
add_action('edited_pa_color', 'save_attribute_color', 10, 2);

function save_attribute_color($term_id, $tt_id) {
    if (isset($_POST['attribute_color']) && '' !== $_POST['attribute_color']) {
        $color = sanitize_hex_color($_POST['attribute_color']);
        update_term_meta($term_id, 'attribute_color', $color);
    } else {
        delete_term_meta($term_id, 'attribute_color');
    }
}

// Завантаження скриптів і стилів для Color Picker
add_action('admin_enqueue_scripts', 'load_color_picker');
function load_color_picker($hook_suffix) {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('my-script-handle', get_template_directory_uri() . '/scripts/color-picker.js', array('wp-color-picker'), false, true);
}