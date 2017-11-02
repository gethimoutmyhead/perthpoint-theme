<?php 
/* Template Name: change-password */
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
        
        $oldPass = $_POST['oldpass'];
        $newPass = $_POST['newpass'];

        
        if ($userPod->field('host_password') == $oldPass){
            $userPod->save('host_password', $newPass);
            echo 'password reset! redirecting...';
            echo '<meta http-equiv="refresh" content="2;url='.$homeURL. '/members-area/">';
        }else{
            echo 'incorrect password, try again';
              echo '<meta http-equiv="refresh" content="2;url='.$homeURL. '/new-password/">';
        }
        
        echo '<a class="memberButton" href="'.$homeURL.'/log-out">Log out here</a>';
    }else{
        //not logged in, re-direct to login page
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/">';
    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>