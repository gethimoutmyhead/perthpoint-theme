<?php 
/* Template Name: Host-signup */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php

            echo 'Do you organise or host events in Perth? We want your events to appear on our page! Sign up here <br>';

            $fields = array( 'e-mail', 'host_password', 'host_name', 'host_address', 'location', 'phone_number', 'website', 'description'); 
            $mypod = pods( 'host' ); 
            
        

            // Output a form with all fields 
            echo '<div>'. $mypod->form($fields, 'Submit', 'thanks?id=X_ID_X') . '</div>'; 
             ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

<?php



?>
