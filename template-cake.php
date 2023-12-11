<?php
/*
Template Name: Cakes
*/
get_header();
$args = array(
    'post_type' => 'Cakes', 
    'posts_per_page' => -1, // -1 to display all posts, or you can set a specific number.
);
$cakes_query = new WP_Query($args);
if ($cakes_query->have_posts()) :?>
    <div>
    <?php
    while ($cakes_query->have_posts()) : $cakes_query->the_post();
    ?>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_content(); ?>
        <?php
    endwhile;
    wp_reset_postdata();
    endif;
    ?>

    </div>

    <div>
        <?php
        $tags = get_terms(['taxonomy' => 'cake_tag']);

        // Check if there are any tags
        if (!empty($tags)) {
            echo '<h3>Tags:</h3>';
            echo '<ul>';
            foreach ($tags as $tag) {
                echo '<li><a href="' . get_term_link($tag -> term_id) . '">' . $tag->name . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    
<?php
get_footer();
?>
