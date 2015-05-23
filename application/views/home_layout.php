<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootswatch.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        ACA VA EL CONTENT
       
            <?php
        foreach ($videos->list as $video) {
            ?>
            <a href="<?php echo base_url(); ?>/Video/view/<?php echo $video->id ?>">
               <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
            </a>
            <?php
        }
        ?>
        

        <?php $this->load->view('footer'); ?>
    </body>
</html>