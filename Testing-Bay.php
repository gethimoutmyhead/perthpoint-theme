<?php
    /* Template Name: Testing-Bay.php */
    get_header();


?>
<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
<?php
    //testing bay
    $testLat = "-31.7450";
    $testLong = "115.7661";
    $sqlLatitudeQuery = "(substring(coordinates.meta_value, 1,INSTR(coordinates.meta_value,',')-1))";
    $sqlLongitudeQuery = "(substring(coordinates.meta_value, INSTR(coordinates.meta_value,',')+1, length(coordinates.meta_value)))";
    $dLat = "((" . $testLat . " - " . $sqlLatitudeQuery . "))";
    $dLong = "((" . $testLong . " - " . $sqlLongitudeQuery . "))";

    $sqlDistanceCalc = "2 * 3961 * asin(sqrt((sin(radians((" . $testLat . " - " . $sqlLatitudeQuery . ") / 2))) ^ 2 + cos(radians(". $testLat . ")) * cos(radians(". $sqlLongitudeQuery . ")) * (sin(radians((" . $sqlLongitudeQuery ." - " . $testLong . ") / 2))) ^ 2))";
    
    $sqDist = "3956 * 2 * ASIN(
          SQRT( POWER(SIN((" . $testLat . " - abs(" . $sqlLatitudeQuery . ")) * pi()/180 / 2), 2) 
              + COS(" . $testLong . " * pi()/180 ) * COS(abs(" . $sqlLatitudeQuery . ") * pi()/180)  
              * POWER(SIN((" . $testLong . " - " . $sqlLongitudeQuery . ") * pi()/180 / 2), 2) ))";

    $sqDist2 = "2 * 3961 * asin(sqrt((sin(radians((" . $sqlLatitudeQuery . " - " . $testLat . ") / 2))) ^ 2 + cos(radians(" . $testLat . ")) * cos(radians(" . $sqlLatitudeQuery . ")) * (sin(radians((" . $sqlLongitudeQuery . " - " . $testLong . ") / 2))) ^ 2))";

    $pythagDist = "SQRT(POWER(" . $dLat . ",2) + POWER(" . $dLong . ",2))";
    $haverLat = "((1 - COS(radians(" . $dLat . ")))/2)";
    $haverLong = "((1 - COS(radians(" . $dLong . ")))/2)";
    $LatCosSquared = "(cos(radians(" . $sqlLatitudeQuery . ")) * cos(radians(" . $testLat . ")))";
    $SQRDA = "(sqrt(" . $haverLat . " + " . $LatCosSquared . " * " . $haverLong . "))";
    $haverDist = "(2 * 6375 * ASIN(" . $SQRDA . "))";

    //$Ahav = "SQRT(5)";

    //$sqlDistanceCalc = $testLat . ' - 5';
     echo $sqlDistanceCalc . "<br>";
    $params = array(
        //'select' => "*, substring(coordinates.meta_value, 1,INSTR(coordinates.meta_value,',')-1) as latitude, substring(coordinates.meta_value, INSTR(coordinates.meta_value,',')+1, 50) as longitude, 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $perthLat .  " - abs(substring(coordinates.meta_value, 1,INSTR(coordinates.meta_value,',')-1))) * pi()/180 / 2), 2) + COS(" . $perthLong . " * pi()/180 ) * COS(abs(substring(coordinates.meta_value, 1,INSTR(coordinates.meta_value,',')-1)) * pi()/180)  * POWER(SIN((" . $perthLong . " - substring(coordinates.meta_value, INSTR(coordinates.meta_value,',')+1, 120)) * pi()/180 / 2), 2) )) AS distance",
        'select' => "*, " . $sqlLatitudeQuery . " as latitude, ".$sqlLongitudeQuery . " as longitude, " . $haverDist . " as distance",
        'limit' => '20',
        'where' => 'coordinates.meta_value != "Unable to automatically detect coordinates"',
        'orderby' => 'distance ASC',
        );
    $eventsPod = pods('event', $params) ;
    echo $eventsPod->total() . '<br>';
    while ($eventsPod->fetch()){
        echo ($eventsPod->field('latitude')) . ',';
        echo ($eventsPod->field('longitude')) . ',';
        print ($eventsPod->field('distance'));
        echo ($eventsPod->field('venue'));
        echo $testLong - $eventsPod->field('longitude');
        echo '<br>';
    }
    /*
    echo ($eventsPod->field('latitude')) . ',';
    echo ($eventsPod->field('longitude')) . ',';
    echo ($eventsPod->field('distance'));
    */
 ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>