<?php 
/* Template Name: new-password */
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
        echo '<h1>' .$_SESSION['Hostname'] . ' password reset </h1>';
        echo '<form action="'.$homeURL. '/change-password" method="POST">
Original password <input type="password" name="oldpass" required /><br>
New password <input type="password" name="newpass" required /><br>
<input type="submit">
</form>';
        
    }else{
        //not logged in, re-direct to login page
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/">';
    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>