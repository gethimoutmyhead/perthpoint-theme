<?php 
/* Template Name: add final dates */
get_header();
?>

<div class="mh-wrapper clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <?php

            //place your code here
            $totalEdits = 0;
            $params = array(
                'limit' => -1,

                );
            $eventPods = pods('event', $params);
            if ( 0 < $eventPods->total() ) { 
                while ( $eventPods->fetch() ) { 
                    $startDate = $eventPods->field('event_date');
                    $finalDate = $eventPods->field('final_date');
                    echo '"'. $finalDate . '" ssup <br>';
                    echo strlen($finalDate);
                    if (strlen($finalDate) == 0){
                        $eventPods->save('final_date', $startDate);
                        $totalEdits = $totalEdits + 1; 
                    }
                    
                }
            }
            
            echo $totalEdits . " events edited ";
        ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>