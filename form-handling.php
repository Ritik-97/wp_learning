<?php

if (isset($_POST['submitform'])){
    if(empty($_POST['title']) || empty($_POST['content'])){
  ?>
  <script> alert("Fields can't be empty!!!!")</script>
  <?php  
    
    }
    else{
    $posttitle = $_POST['title'];
    $postcontent = $_POST['content'];
        
    //logic

    $new_post= array(
        'post_title' =>$_POST['title'],
        'post_content'=> $_POST['content'],
        'post_type'=> 'Cakes',
        'post_status'=> 'publish',

    );  
    $post_id= wp_insert_post($new_post);
    // echo "submit";

}

}

?>
