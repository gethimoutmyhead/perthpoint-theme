<?php 
/* Template Name: host-login */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php


            $homeURL = get_home_url();

    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Hostname']))
    {
        //successfully logged in, go to members area
        
        $hostID = $_SESSION['HostID'];
        
        $userPod = pods('host', $hostID);
 
        echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/members-area/">';
    }else{
        //display login page
        echo '<h1> Member Login page </h1>';
        echo '<form action="'. $homeURL . '/detail-check" method="POST">
<div class="pods-field-label">
<label class="pods-form-ui-label pods-form-ui-label-pods-field-e-mail" for="pods-form-ui-pods-field-e-mail"> e-mail</label>
</div>
<div class="pods-field-input">
<input type="text" name="username" required>
</div>
<div class="pods-field-label">
<label class="pods-form-ui-label pods-form-ui-label-pods-field-e-mail" for="pods-form-ui-pods-field-e-mail"> password </label>
</div>
<div class="pods-field-input">
<input type="password" name="password" required>
</div>
<input type="submit">

</form>
<a class ="memberButton" href="'. $homeURL . '/host-signup">Not Registered?</a>
<a class ="memberButton" href="' . $homeURL . '/forgot-password">Forgot password?</a>
';

    }


 

        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>