<?php 
    /* Template Name: logout.php */
    $_SESSION = array(); session_destroy(); 
    get_header();
?>
<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
    
   You have successfully logged out.
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>