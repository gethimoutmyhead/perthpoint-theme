<?php

    /* Template Name: check-details.php */
get_header();
?>
<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
<?php
    $homeURL = get_home_url();



    $username = ($_POST['username']);
    $password = ($_POST['password']);
    //$username = 'theshashiman@gmail.com';
    //$password = 'default';

    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Redirecting...<br>"; 
        echo '<meta http-equiv="refresh" content="1;url=' .$homeURL. '/host-login/" >';
        return;
    }

        if (!$username || !$password){
            echo 'nothing submitted. Redirecting...';
            echo '<meta http-equiv="refresh" content="1;url=' .$homeURL. '/host-login/" >';
            return;
        }
 
            $params = array(
                'where' => 'e-mail.meta_value = "'.$username. '" AND host_password.meta_value = "' . $password . '"',
            );
            $userPod = pods('host', $params);

            //echo $userPod->field('host_name') . '<br>';
        if ($userPod->total() == 1){
            echo 'Successfully logged in! Redirecting..';
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['Hostname'] = $userPod->field('host_name');
            $_SESSION['HostID'] = $userPod->field('ID');
            echo '<meta http-equiv="refresh" content="3;url=' .$homeURL. '/members-area/"  >';
            return;
        }else{
            echo 'Invalid e-mail or password - redirecting..';
             echo '<meta http-equiv="refresh" content="2;url=' .$homeURL. '/host-login/" >';
            return;
        }
    
?>
        </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
        