<?php
/*
Template Name: post-form
*/
get_header();
echo do_shortcode('[custom_form]'); 
include get_stylesheet_directory(). '/form-handling.php';
?>
