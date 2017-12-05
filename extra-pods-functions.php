<?php
//extra pods functions

//add custom JS functions
function add_custom_script() {
    wp_register_script('google_maps_api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDWnGVLjU3bQ1FS24kR_wBKCMN2d2o3ltI&outputFormat=JSON', array( 'jquery' ));
    wp_enqueue_script('google_maps_api');


    wp_register_script('custom_script', get_template_directory_uri(). '/js/custom-functions.js', array( 'jquery' ));
    wp_enqueue_script('custom_script');
}  

add_action( 'wp_enqueue_scripts', 'add_custom_script' );
  
function add_custom_admin_script() {

    wp_register_script('google_maps_api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDWnGVLjU3bQ1FS24kR_wBKCMN2d2o3ltI&outputFormat=JSON', array( 'jquery' ));
    wp_enqueue_script('google_maps_api');


    wp_register_script('custom_admin_script', get_template_directory_uri(). '/js/custom-admin-functions.js', array( 'jquery' ));
    wp_enqueue_script('custom_admin_script');
}  

add_action( 'admin_enqueue_scripts', 'add_custom_admin_script' );

function my_long_date($input_date) {
     return date("l, jS F Y", strtotime($input_date));     
     
}

function my_short_date($input_date) {
     return date("jS F", strtotime($input_date));     
     
}
function my_short_date_year($input_date) {
     return date("jS F Y", strtotime($input_date));     
     
}

function display_price($input_price) {
    $cost = 'FREE';

    if ($input_price != 0){
	   $cost = '$' . $input_price;
    }
    return ($cost);
}
function display_event_date($obj){

    $finalDate = $obj->field('final_date');
    $eventDate = $obj->field('event_date');
    if ($eventDate != $finalDate){
        return( my_short_date($eventDate) . ' to ' . my_short_date_year($finalDate) );
    }else{
        return ( my_long_date($eventDate) );
    }
}



function display_max_price($input_price) {
    $cost = '';             // if max price is 0 don't display anything

    if ($input_price != 0){
	   $cost = ' to $' . $input_price;
    }
    return ($cost);
}

function getURLofID($inputID){
    return get_permalink($inputID);
}

function getThumbnailofID($inputID){
    return get_the_post_thumbnail($inputID, 'thumbnail');
}



function content_to_excerpt($sentence) {
    $count = 10;
    preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
    return $matches[0];
}

function location_in_URL_format($location){
    $location_reformatted = str_replace(' ', '+', $location);
    $location_URL = 'http://maps.google.com/maps?q=' . $location_reformatted;
    return $location_URL;
}

function sortedDaysOfWeek($dayArray){
    $returnString = "";
    $inputDays = "";
    $addComma = "";
    
    if (!empty($dayArray)){
        foreach ($dayArray as $inDay){
            $inputDays .=  get_the_title($inDay['ID']);
        }
    }
    
    
    $poss = strpos($inputDays, 'Monday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Monday';
        $addComma = ", ";
        
    }
    $poss = strpos($inputDays, 'Tuesday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Tuesday';
        $addComma = ", ";
        
    }
    $poss = strpos($inputDays, 'Wednesday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Wednesday';
        $addComma = ", ";
        
    }
        $poss = strpos($inputDays, 'Thursday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Thursday';
        $addComma = ", ";
        
    }
    $poss = strpos($inputDays, 'Friday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Friday';
        $addComma = ", ";
        
    }
    $poss = strpos($inputDays, 'Saturday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Saturday';
        $addComma = ", ";
        
    }
    $poss = strpos($inputDays, 'Sunday');
    if ($poss !== false){
        
        $returnString .= $addComma . 'Sunday';
        $addComma = ", ";
        
    }
    
    //$returnString = "";
    
    if (strlen($returnString) > 9){
        $lastDay = strrpos($returnString, " ");
        $finalStr = substr_replace($returnString, " and ", $lastDay, 0);
    }else{
        $finalStr = $returnString;
    }
    
    
    return ("Every " . $finalStr);
}



add_filter( 'pods_shortcode_findrecords_params', 'findTodayAndLater', 10, 2 );
function findTodayAndLater( $params, $pod ) {
   
	if ( isset( $params[ 'where' ] ) ) {

        $test_date = 'final_date.meta_value >= NOW() - INTERVAL 1 DAY';
        $params[ 'where' ] = str_replace('todayorlater', $test_date, $params['where']);
        
        $test_date = 'expiry_date.meta_value >= NOW() - INTERVAL 1 DAY';
        $params[ 'where' ] = str_replace('notExpired', $test_date, $params['where']);
        
	}
	return $params;
}


// add google geocoding API

//add filters for events, regular weekly events, and hosts
add_filter('pods_api_pre_save_pod_item_host','lowgravity_geo_pre_save',10,2);
add_filter('pods_api_post_save_pod_item_host','add_feature_image',10,2);
add_filter('pods_api_pre_save_pod_item_event','lowgravity_geo_pre_save',10,2);
add_filter('pods_api_pre_save_pod_item_regular','lowgravity_geo_pre_save',10,2);

add_action('pods_api_post_save_pod_item_event','approve_event_email',10,3);

add_filter('pods_form_ui_field_text', 'lowgravity_disable_coordinates_field', 10, 6);


function approve_event_email($pieces, $is_new_item, $id){
    
    $event_page = get_permalink($id);//$pieces['fields']['event_name']['value'];
    $event_name = $pieces['fields']['event_name']['value'];
    $host_id = (int)$pieces[ 'fields' ][ 'organiser' ][ 'value' ];
    
    $host_email = get_post_meta($host_id, 'e-mail', true);
    
    $event_post_status = get_post_status($id); //$pieces[ 'fields' ][ 'post_status' ];
    //$pieces['fields']['web_page']['value'] = 'google.com';
    //pods('event', $id)->save('web_page', 'http://www.yahoo.com');
    //update_post_meta($id, 'web_page', 'http://www.altavista.com');

    /**
    $data = array(
        'web_page' => 'http://www.google.com'
    );
    pods('event', $id)->save($data);
    **/

    $original_organiser_email = $pieces['fields']['original_organiser_email']['value'];
    
    //$host_id = 'sizerp';
    
    /**
    if ($event_post_status == 'draft'){
        $email = 'theshashiman@gmail.com';
        $subject = 'New event submitted';
        $comment = 'Hey there,
        
        a new event - '. $event_name . '-  has been submitted to our page. 
        
        View it here - '. $event_page . '
        
        Please review it for submission.
        
        PerthPoint.com.au
        
        ';
            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
    }
    **/
    
    if ($event_name){
        $hets = (string)get_post_meta($id, 'host_emailed_timestamp')[0];
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $hets );

                
        $host_emailed_timestamp = $d->getTimeStamp();

        if (($host_emailed_timestamp + 86400) < time() ){  
            //update_post_meta($id,'description',  'eat my shoesss30' );//test line. to be removed when code works
            $email = $host_email;
            $subject = 'Your event - ' . $event_name . ' is approved for submission on PerthPoint!';
            $comment = 'Hey there,
    
We wanted to let you know that your new event - ' . $event_name . ' - has been added to our website!
    
View it here:' . $event_page . '
    
Trisha
www.perthpoint.com.au
    
    ';
            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');

            update_post_meta($id, 'host_emailed_timestamp', date('y-m-d h:m',time() ) );


        }




    
            if ($original_organiser_email){
                //$original_organiser_email_timestamp_string = (get_post_meta($id, 'original_organiser_email_timestamp')[0]);
                $ooets = (string)get_post_meta($id, 'original_organiser_email_timestamp')[0];
                $d = DateTime::createFromFormat('Y-m-d H:i:s', $ooets );
                
                $original_organiser_email_timestamp = $d->getTimeStamp();

                if (($original_organiser_email_timestamp + 86400) < time() ){
                    //update_post_meta($id,'description',  'eat my shoesss5' );//test line. to be removed when code works

                    //send an e-mail to the event organizer encouraging them to join PerthPoint
                    $email = $original_organiser_email;
                    $subject = 'Your event - ' . $event_name . ' is featured on PerthPoint!';
                    $comment = 'Hey there,
        
    We wanted to let you know that your new event - ' . $event_name . ' - has been chosen to feature on our website!
        
    View it here:' . $event_page . '
        
    Join us today on www.perthpoint.com.au/host-signup to edit the event or add more events. It is totally free!

    Feel free to contact us on this address if you are unhappy for any reason.
        
    Trisha
    www.perthpoint.com.au
        
        ';
                    mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
                    update_post_meta($id, 'original_organiser_email_timestamp', date('y-m-d h:m',time() ) );

                }

               



                

            }   
    
    }
    
    


}


add_action('pods_api_post_save_pod_item_host','approve_host_email',10,2);
function approve_host_email($pieces, $is_new_item, $id){
    
    $host_page = get_permalink($id);//$pieces['fields']['event_name']['value'];
    $host_name = $pieces['fields']['host_name']['value'];
    
    
    $host_email = $pieces['fields']['e-mail']['value'];
    
    //$host_post_status = get_post_status($id); //$pieces[ 'fields' ][ 'post_status' ];
    //wp_die(var_dump(get_post_status($id)));
    
    
    if ($host_name && $host_page){
            $email = $host_email;
            $subject = 'Your PerthPoint account has been approved!';
            $comment = 'Hey there,
    
We wanted to let you know that ' . $host_name . ' has been added to our website.


View it here 
' . $host_page . '

Log in and submit your events to PerthPoint today!
www.perthpoint.com.au/host-login/

Trisha
www.perthpoint.com.au
    
    ';
            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
    
    
    }
    


}

function add_feature_image($pieces, $is_new_item, $id){
 $pieces['fields']['post_thumbnail'] = $pieces['fields']['feature_image_dl'];
    return $pieces;
}


 
function lowgravity_geo_pre_save($pieces, $is_new) {
 
 $address_field_name     = 'location';
 $coordinates_field_name = 'coordinates';
 
 //checking if our address field exists
 if(isset($pieces['fields'][$address_field_name])) {
 
 //parsing data 
 $address = urlencode( strtolower( trim($pieces['fields'][$address_field_name]['value'])));
 
 } else {// otherwise do nothing
 
 return $pieces;
 
 }
 
 //preparing url
 $geourl = "http://maps.google.com/maps/api/geocode/json?address=". $address ."&sensor=false";
 
 //get the geocoded info from Google
 $geoinfo = wp_remote_get($geourl); 
 
 //default value for coordinates field
 $coordinates = 'Unable to automatically detect coordinates';
 
 //if the response is OK 
 if( "OK" == $geoinfo['response']['message'] ) {
 
 $json_obj = json_decode($geoinfo['body']);
 $coordinates = $json_obj->results[0]->geometry->location->lat . ',' . $json_obj->results[0]->geometry->location->lng;
 $formatted_address = $json_obj->results[0]->formatted_address;
 } 
 
 if (!$formatted_address){
    
   $formatted_address = $pieces['fields'][$address_field_name]['value'];
 }

 $pieces['fields'][$coordinates_field_name]['value'] = $coordinates;
 $pieces['fields'][$address_field_name]['value'] = $formatted_address;
 
 //returning data 
 return $pieces;
}
 
function lowgravity_disable_coordinates_field($output, $name, $value, $options, $pod, $id) { 
 
    //as this filter is assigned to each text field we need to filter the ones we need 
    if( strstr( $name, 'coordinates' )) {
 
        $output = '<em>This field will be autogenerated from your address</em>' . str_replace('<input', '<input disabled=disabled', $output);
        return $output;
 
    } 
 
    return $output;
 
}
// end of google geocoding api

/* end of extra functions to format Pods magic tag outputs */



function confirm_logged_in(){
    $homeURL = get_home_url();
    if (empty($_SESSION['LoggedIn']) || empty($_SESSION['Hostname'])){
        // not logged in - redirect to login page
         echo '<meta http-equiv="refresh" content="0;url='.$homeURL. '/host-login/">';
        return;
    }
}


?>
