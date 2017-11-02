<?php 
/* Template Name: edit-member */
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
        echo '<h1> Edit Details </h1><br>';
        echo '<h3> Member name: ' . $userPod->field('host_name') . '</h3>';

        
        $fields = array('host_address', 'location', 'phone_number', 'website', 'description');
        echo $userPod->form($fields, 'Submit', $homeURL . '/members-area');
        
        echo '<a class="memberButton" href="'.$homeURL.'/log-out">Log out</a>';
    }else{
        //not logged in, re-direct to login page
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/"';
    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>