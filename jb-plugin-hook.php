<?php 
/*
Plugin Name: Jobair news Ticker
Plugin URI: http://www.jobairbd.com
Description: This  Plugin will enable news ticker in your wordpress theme.You can embed news ticker via shortcode in every where you want.
Author: Jobair
Version: 1.0
Author URI: http://www.jobairbd.com
*/


function jobair_ticker_main_js(){
wp_enqueue_script('jobair-ticker-js',plugins_url('/js/jquery.smarticker.min.js', __FILE__ ), array('jquery'),1.0,false);
wp_enqueue_style('jobair-ticker-css',plugins_url('/css/jquery.smarticker.css', __FILE__ ));
	}
add_action('init','jobair_ticker_main_js');

/* short code*/
function ticker_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => '',
		'category' => '',
		'theme' => '2',
		'speed' => '1500',
		'title' => 'Latest News',
		'rounded' => 'false',
		'animation' => 'default',
		'count' => '5',
	), $atts ) );
	global $post;
     $q = new WP_Query(
        array( 'posts_per_page' => $count, 'post_type' => 'post','category_name' => $category )
        );
$list = ' <script type="text/javascript">
			jQuery(document).ready(function(){			
				jQuery(".smarticker'.$id.'").smarticker({	
				theme: '.$theme.',
				speed: '.$speed.',
				title: "'.$title.'",
				rounded: '.$rounded.',
				animation: "'.$animation.'"
				});
			});
			</script>
					<div class="smarticker'.$id.'">
						<ul>
							
					';


	while($q->have_posts()) : $q->the_post();
    //get the ID of your post in the loop
    $id = get_the_ID();
	        
    $list .= '		
						<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>										
								
	';        
endwhile;
$list.= '</ul></div>';
wp_reset_query();
return $list;
}
add_shortcode('jbticker', 'ticker_shortcode');
?>