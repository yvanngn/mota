<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
get_header();

//echo '  <div class="">
//                    <img src="images/photos/natalie-11.jpg" alt="">
//         </div>';
?>


<select id="category-filter">
    <option value="">Toutes les catégories</option>
    <?php
    $categories = get_terms('categorie');
    foreach ($categories as $category) {
        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
    }
    ?>
</select>

<select id="format-filter">
    <option value="">Tous les formats</option>
    <?php
    $formats = get_terms('format');
    foreach ($formats as $format) {
        echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
    }
    ?>
</select>

<select id="sort-filter">
    <option value="">Tri</option>
    <option value="ASC">Tri récents</option>
    <option value="DESC">Tri précédent</option>
</select>
<?php
if (have_posts()) :
    while (have_posts()) : the_post();

        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            echo '<div class="image-list">';
//            while ($query->have_posts()) : $query->the_post();
//
//                $thumbnail_id = get_post_thumbnail_id();
//                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large');
//                ?>
<!--                <div class="image-item">-->
<!--                    <img src="--><?php //echo esc_url($thumbnail_url[0]); ?><!--" alt="--><?php //the_title(); ?><!--">-->
<!--                </div>-->
<!--            --><?php
//            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo 'Aucun article trouvé.';
        endif;
    endwhile;
else :
    echo 'Aucun contenu trouvé.';
endif;
?>
    <button id="load-more">Voir plus</button>
<?php
get_footer();
?>
<div id="contact-modal" class="modal">
    <div class="modal-content">

        <span id="close-contact-modal" class="close">&times;</span>

        <div class="cf7-form">
            <?php echo do_shortcode('[contact-form-7 id="87c748b" title="Formulaire de contact"]'); ?>
        </div>
    </div>
</div>