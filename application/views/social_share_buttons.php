<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');

$facebook = true;
$twitter = true;
$googleplus = true;

//Social popup window atts
$atts = array(
    'width'      => '550',
    'height'     => '300',
    'scrollbars' => 'yes',
    'status'     => 'yes',
    'resizable'  => 'yes',
    'screenx'    => '0',
    'screeny'    => '0'
);

?>

<div class="social_btns_container" >
    <div id="toolbar" class="">
        <div id="toolbar1" style="display: inline-block;">
            <?php
            $base_url = base_url();
            $uri_str = uri_string();
            
            if($facebook){
                echo anchor_popup(
                    'https://www.facebook.com/sharer/sharer.php?u='.$base_url .$uri_str,
                    '<img onmouseover="this.style.opacity = 0.8;" onmouseout="this.style.opacity = 1;" style="margin-right: 5px;padding-right: 5px; padding-top: 5px; display: inline-block; border: 0px; outline: none; width: 24px; height: 24px; box-shadow: none; max-width: none; opacity: 1; background-color: transparent;" src="'.$base_url.'css/images/social/facebook.png" title="Facebook">',
                    $atts
                );
            }
            if($twitter){
                echo anchor_popup(
                    'https://twitter.com/home?status='.$base_url . $uri_str,
                    '<img onmouseover="this.style.opacity = 0.8;" onmouseout="this.style.opacity = 1;" style="margin-right: 5px;padding-right: 5px; padding-top: 5px;  display: inline-block; border: 0px; outline: none; width: 24px; height: 24px; box-shadow: none; max-width: none; opacity: 1; background-color: transparent;" src="'.$base_url.'css/images/social/twitter.png" title="Twitter">',
                    $atts
                );
            }
            if($googleplus){
                echo anchor_popup(
                    'https://plus.google.com/share?url='.$base_url . $uri_str ,
                    '<img onmouseover="this.style.opacity = 0.8;" onmouseout="this.style.opacity = 1;" style="margin-right: 5px;padding-right: 5px; padding-top: 5px; display: inline-block; border: 0px; outline: none; width: 24px; height: 24px; box-shadow: none; max-width: none; opacity: 1; background-color: transparent;" src="'.$base_url.'css/images/social/googleplus.png" title="Google Plus">',
                    $atts
                );
            }
            ?>
        </div>
    </div>
</div>