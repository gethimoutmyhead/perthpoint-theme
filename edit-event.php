<?php 
/* Template Name: Edit event */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php


            $homeURL = get_home_url();

    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Hostname']))
    {
        //successfully logged in
        
        $hostID = $_SESSION['HostID'];
        
        $userPod = pods('host', $hostID);
        $eventID = $_GET['eventID'];
        
        $eventPod = pods('event', $eventID);
        if ($eventPod->field('organiser.ID') != $hostID){
            //logged in host does not own this event, re-direct
            echo 'You are not authorised to edit this event, redirecting...';

            echo '<meta http-equiv="refresh" content="2;url='.$homeURL. '/members-area/"><br>';
            
        }else{
        echo '<h1> Edit Details </h1><br>';
        echo '<h3> Member name: ' . $_SESSION['Hostname'] . '</h3>';
        echo '<h4> Event name: ' . $eventPod->field('event_name') . '</h3>';
            
            $postContent = $eventPod->field('post_content');
            $eventPod->save('description', $postContent);
            
            
            $fields = array('event_date', 'final_date', 'start_time', 'end_time', 'minimum_price', 'maximum_price', 'venue', 'location', 'web_page', 'description');
            echo $eventPod->form($fields,'Submit', $homeURL . '/add-event-details?eventID=X_ID_X');
        }
        
        
        echo '<a class="memberButton" href="'.$homeURL.'/log-out">Log out here</a>';
    }else{
        //not logged in, re-direct to login page
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/"';
    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>