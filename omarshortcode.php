<?php
/* Plugin Name: omarplugin
Plugin URI: https://twitter.com/omarzaffar
Description: Shotcode for Assignment 1 - CCT460
Author: Omar Akhund
Author URI: https://twitter.com/omarzaffar
Version: 1.0
*/

/*
Omar Akhund - Assignment 2 - 
Shortcodes and custom post type

echo "# omarplugin" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/omarakhund/omarplugin.git
git push -u origin master
*/


//Shortcode for creating a button that links to their personal website

function omar_button ( $ats, $content = null){
	extract(shortcode_atts(
		array(
			'title'		=>'For more information, click here!',
			'link'		=>'',
			), $atts
		));
	return'<p class="the-link"><a href="'.$link.'">'.$title.'</a></p>';
}

add_shortcode('omar_button','omar_button');