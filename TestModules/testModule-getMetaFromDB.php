<?php 
/* Template Name: testModule-getMetaFromDB */
get_header();
?>

<?php
	global $wpdb;
	//$results = $wpdb->get_results( 'SELECT meta_key, meta_value FROM SoPerthweblog_postmeta WHERE post_id = 2172', OBJECT );
	$eventID = (string)2172;
	$eventPod = pods('event', $eventID);
	$postTitle = $eventPod->field('post_title') . ' is best captain now';
	echo $postTitle;

	$results = $wpdb->update('SoPerthweblog_postmeta', array('meta_value'=>$postTitle), array('post_id'=>$eventID,'meta_key'=>'event_name'));

	var_dump($results);	
?>