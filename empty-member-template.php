<?php 
/* Template Name: empty member template */
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
        
        $newEventPod = pods('event');
        echo 'there never was a password';
        
        
        echo '<a href="'.$homeURL.'/log-out"><button>Log out here</button> </a>';
    }else{
        //not logged in, re-direct to login page
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/">';
    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>