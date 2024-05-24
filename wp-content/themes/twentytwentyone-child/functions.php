<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );

}


function enqueue_child_theme_scripts() {

    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js', array(), null, true);
    wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array(), null, true);
    wp_enqueue_script('child-theme-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), null, true);
    wp_localize_script('child-theme-script', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'rest_url' => esc_url_raw(rest_url())
    ],
    );
//   wp_localize_script('child-theme-script', 'ajax_object', [
//            'ajax_url' => admin_url('admin-ajax.php'),
//            'scripts_params' => esc_url_raw(rest_url())
//    ],
//    );

}

add_action('wp_enqueue_scripts', 'enqueue_child_theme_scripts');

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos() {
    $category = $_POST['category'];
    $format = $_POST['format'];
    $sort = $_POST['sort'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }


    if ($sort) {
        $args[] = array(
            'orderby' => 'date',
            'order' => $sort,
        );
    }
    var_dump($args);
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large');
            ?>
            <div class="image-item">
                <img src="<?php echo esc_url($thumbnail_url[0]); ?>" alt="<?php the_title(); ?>">
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune photo trouvée.';
    endif;

    die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 6;
    $category = $_POST['category'];
    $format = $_POST['format'];
    $sort = $_POST['sort'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $per_page,
        'offset' => $offset,
        'post_status' => 'publish',
    );

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large');
            ?>
            <div class="image-item">
                <img src="<?php echo esc_url($thumbnail_url[0]); ?>" alt="<?php the_title(); ?>">
            </div>
        <?php
        endwhile;
    else :
        echo 'Aucune photo trouvée.';
    endif;
    die();
}
add_image_size('custom-thumbnail-size', 250, 250, true);
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key' => 'group_65a0345b7cf60',
        'title' => 'Photo',
        'fields' => array(
            array(
                'key' => 'field_65a0345c06028',
                'label' => 'Type',
                'name' => 'type',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_65a0347c06029',
                'label' => 'Référence',
                'name' => 'reference',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ) );
} );
