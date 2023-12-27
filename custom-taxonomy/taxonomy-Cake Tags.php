<?php
    if(have_posts()){
        while (have_posts()){
            the_post();
            echo '<a href="'.get_permalink().'" title="'.$post->post_title.'" class="issue-text">'.$post->post_title.' </a>';
            the_content('');
        }
    }
    ?>