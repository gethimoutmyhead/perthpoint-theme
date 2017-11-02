<?php
    /* Template Name: thanks */
    get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
<?php
    $id = $_GET['id'];
    
    //echo 'Congratulations, your account has successfully been submitted! You should receive an e-mail from us shortly.';

    $host_name = get_post_meta($id, 'host_name', 'true');
    $email = get_post_meta($id, 'e-mail', 'true');
        
    $params = array(
        'where' => 'e-mail.meta_value = "'.$email .'"',
        
    );
        
    $email_search = pods('host', $params);
        
    if ($email_search->total()){
        echo $email . ' already has an account on our website.<br><br>';
        
        $newHost = pods('host', $id);
        $baleted = $newHost->delete();
        
        echo '<a class ="memberButton" href="' . $homeURL . '/forgot-password">Reset password?</a>';
        
    } 
    else{
        echo 'Congratulations, your account has successfully been submitted! You should receive an e-mail from us shortly.';
             $my_post = array(
                 'ID'           => $id,
                 'post_title'   => $host_name,
            );

        // Update the post into the database
          wp_update_post( $my_post );

          //Email information
          $admin_email = "admin@perthpoint.com.au";

          $subject = "Thank you for registering with PerthPoint!";
          $comment = "Hey there,

          Thanks for taking the time to register ". $host_name . " with PerthPoint! We will be in contact shortly with confirmation.

          Cheers,
          The PerthPoint Team";

          //send email
          mail($email, $subject, $comment, "From:" . $admin_email);
  
    }

 

?>
    </div>
    <?php get_sidebar(); ?>
</div>
    <?php get_footer(); ?>