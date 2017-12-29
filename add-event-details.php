<?php 
/* Template Name: add-event-details */
    confirm_logged_in();
    get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php


            $homeURL = get_home_url();

            $hostID = $_SESSION['HostID'];
            $hostName = $_SESSION['Hostname'];

            $userPod = pods('host', $hostID);
            $eventID = $_GET['eventID'];

            $eventPod = pods('event', $eventID);
        

            $postName = $eventPod->field('event_name') . ' @ ' . $eventPod->field('venue');
            $description = $eventPod->field('description');
            $ft_image = $eventPod->field('ft_image_upload.ID');

        
            $edit_event_pod_link = get_bloginfo( 'url' ) . '/wp-admin/post.php?post=' . $eventID . '&action=edit';
        
            if (($eventPod->field('organiser.ID') == 0) || $eventPod->field('organiser.ID') == $hostID){
                $eventPod->save('organiser', $hostID);
                //$eventPod->save('post_title', $postName);

                global $wpdb;
                $eventIDString = (string)$eventID;
                $postTitle = $eventPod->field('post_title');
                $results = $wpdb->insert('SoPerthweblog_postmeta', array('meta_value'=>$postTitle,'post_id'=>$eventIDString,'meta_key'=>'event_name'));

                $eventPod->save('post_content', $description);
                //$eventPod->save('post_thumbnail', $ft_image);
                set_post_thumbnail($eventID, $ft_image);
                echo 'Event submitted! We will review your event shortly';
                echo '<meta http-equiv="refresh" content="2;url='.$homeURL. '/members-area/ ">';
                
            $email = 'theshashiman@gmail.com, admin@perthpoint.com.au, trisha_d17@hotmail.com';
            //$email = 'theshashiman@gmail.com, admin@perthpoint.com.au';
            $subject = 'A new event has been submitted to PerthPoint!';
            $comment = 'Hey there,
    
We wanted to let you know that a new event - ' . $eventPod->field('post_title') . ' - has been submitted to our website!
    
Please review it for approval.
    
' . $edit_event_pod_link;

            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
                
            }else{
                echo 'you are not authorised to edit this event';
                echo '<meta http-equiv="refresh" content="2;url='.$homeURL. '/members-area/ ">';
            }
        
        //echo '<a class="memberButton" href="'.$homeURL.'/log-out">Log out here</a>';

 

 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>