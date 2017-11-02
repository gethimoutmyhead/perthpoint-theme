<?php
    /* Template Name: members-area.php */
get_header();
?>
<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
<?php
    $homeURL = get_home_url();

    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Hostname']))
    {
        //echo 'Congratulations '. $_SESSION['Hostname'] . ' you have successfully logged in! ';
        echo '<h1> Members Area: ' . $_SESSION['Hostname'] . '</h1>';
        
        $hostID = $_SESSION['HostID'];
        
        $userPod = pods('host', $hostID);
        
        echo $userPod->template('host-members');
        
        echo '<a class ="memberButton" href="'.$homeURL.'/edit-member">Edit details</a> ';
        echo '<a class ="memberButton" href="'.$homeURL.'/new-password">Change password</a> ';
        echo '<a class ="memberButton" href="'.$homeURL.'/log-out">Log out</a>';
        
        $params = array(
            'where' => 'organiser.ID = "' . $hostID . '"',
            'orderby' => 'event_date.meta_value DESC',
            'limit' => '-1',
            );
        $eventsPod = pods('event', $params);
        echo '<h2> Events </h2><br>';
        echo '<a class ="memberButton" href="'.$homeURL.'/add-new-event">Add New Event</a><br><br>';
        echo $eventsPod->template('member-event-multi');
        
    }else{
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/"';
    }


 ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>