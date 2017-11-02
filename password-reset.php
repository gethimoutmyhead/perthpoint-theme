<?php 
/* Template Name: password-reset */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php

            //place your code here
            $email = $_POST['email'];

            $params = array(
                'where' => 'e-mail.meta_value = "' . $email . '"',
                );
            $userPod = pods ('host', $params);

if ($userPod->total() == 1){

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
    $host_name = $userPod->field('host_name');
    $userPod->save('host_password', $randomString);
    
    $admin_email = "admin@perthpoint.com.au";

    $subject = "PerthPoint - password reset";
    $comment = "Hey there,
  
  The new password for ". $host_name . " at PerthPoint.com.au is " . $randomString . " - Log into our website on www.perthpoint.com.au/host-login .
  
  Please reset your password after logging in.
  
  Cheers,
  The PerthPoint Team";
 
  //send email
  mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
    
    echo 'If an account was assigned to this e-mail address, a new password has been sent to your email. Please reset your password after logging in';
}
            
        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>