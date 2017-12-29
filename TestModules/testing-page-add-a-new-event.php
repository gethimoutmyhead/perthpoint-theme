<?php 
/* Template Name: testModule-add-a-new-event */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php


            $homeURL = get_home_url();

 
        //successfully logged in
        
        $hostID = 634; //$_SESSION['HostID'];
        
        $userPod = pods('host', $hostID);

        
        $eventPod = pods('event');

        echo '<h1> Add New Event </h1><br>';
        echo '<h3> Member name: ' . $_SESSION['Hostname'] . '</h3>';

            $eventPod = pods ('event' );
            echo '<div id=penis>';
            $fields = array('event_name', 'ft_image_upload', 'event_date', 'final_date', 'start_time', 'end_time', 'minimum_price', 'maximum_price', 'venue', 'location', 'web_page', 'description');
            //echo $eventPod->form($fields,'Submit',$homeURL . '/add-event-details?eventID=X_ID_X');
            echo '</div>';

			$my_post = array(
			     'post_title' => 'Shashi',
			     'post_content' => 'This is my post.',
			     'post_status' => 'publish',
			     'post_type' => 'regular',
			     'event_name'=>'perth arena',
			     

			  );

			//$post_id = wp_insert_post($my_post);

        	$pod2 = pods( 'event', 2166 );

        	$dat = array(
        		'event_name' => 'Shishka',
        	);
        	$z = update_metadata('post', 2166,'event_name', (string)'Shishka Bob is not a twat');
        	//update_metadata( 'post', $post_id, $meta_key, $meta_value, $prev_value );
        	echo $z;
        	//$pod2->save($dat);
        	$pod = pods('event');

        	//$trr = $pod2->validate($dat);
        	//echo 'Validation is ' . $trr;
        	//$new_event_id = $pod->add($my_post);
        	echo $new_event_id;
        



 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>