<?php
//extra pods functions


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

add_action('pods_api_post_save_pod_item_event','approve_event_email',10,2);

add_filter('pods_form_ui_field_text', 'lowgravity_disable_coordinates_field', 10, 6);


function approve_event_email($pieces, $is_new_item, $id){
    
    $event_page = get_permalink($id);//$pieces['fields']['event_name']['value'];
    $event_name = $pieces['fields']['event_name']['value'];
    $host_id = (int)$pieces[ 'fields' ][ 'organiser' ][ 'value' ];
    
    $host_email = get_post_meta($host_id, 'e-mail', true);
    
    $event_post_status = get_post_status($id); //$pieces[ 'fields' ][ 'post_status' ];
    
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
            $email = $host_email;
            $subject = 'Your event - ' . $event_name . ' is approved for submission on PerthPoint!';
            $comment = 'Hey there,
    
We wanted to let you know that your new event - ' . $event_name . ' - has been added to our website!
    
View it here:' . $event_page . '
    
Trisha
www.perthpoint.com.au
    
    ';
            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');
        }
            if ($original_organiser_email){
                //send an e-mail the event organizer encouraging them to join PerthPoint
                $my_file = 'test.txt';
                $handle = fopen($my_file,'w');
                fwrite($handle, $original_organiser_email . " is happy");

                $email = $host_email;
                $subject = 'Your event - ' . $event_name . ' is featured on PerthPoint!';
                $comment = 'Hey there,
    
We wanted to let you know that your new event - ' . $event_name . ' - has been added to our website!
    
View it here:' . $event_page . '
    
Join us today on www.perthpoint.com.au/host-login to edit the event or add more events. It is totally free!

Alternatively, we can take the event down and remove you from future correspondence, just e-mail us back.
    
Trisha
www.perthpoint.com.au
    
    ';
            mail($email, $subject, $comment, "From:" . 'admin@perthpoint.com.au');

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