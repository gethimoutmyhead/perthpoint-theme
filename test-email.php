<?php
//if "email" variable is filled out, send email
 
  //Email information
  $admin_email = "doctorstohome@outlook.com";
  $email = "theshashiman@gmail.com";
  $subject = "test email";
  $comment = "this has been a successful test";
  
  //send email
  mail($admin_email, "$subject", $comment, "From:" . $email);
  
  //Email response
  echo "Thank you for contacting us!";
  }
  
  //if "email" variable is not filled out, display the form

?>