
<?php
/*Template Name: News*/
get_header();
// $cat = get_categories(array('taxanomy'=>'category'));
// echo "<pre>";
// print_r($cat);
// echo "</pre>";
$items = array(
    'post_type' => 'news'
);
$wpquery_techs = new WP_Query($items);
?>
<div>
<?php
while ($wpquery_techs->have_posts()){
    $wpquery_techs->the_post(); ?>
<p style='margin:1rem 0;color:#0095ff; font-style:italic; font-size:25px'><?php the_title(); ?></p>
<p><?php the_content(); ?></p>
<button><a href="<?php the_permalink(); ?>" style='color:white'>Read more...</a></button>
<?php }?></div>
<?php
get_footer();
?>