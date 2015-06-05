<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-rating.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-rating.min.js"></script> 
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <?php if ($history !== null && $history->list !== null) {
            ?>
            <div class="col-lg-12">
                <div style="  background-color: white;width: 100%;height: auto;overflow: hidden;padding: 15px 5px;">
                    <p style=" margin-bottom: 0px; margin-left: 15px; font-size: 15px;line-height: 10px;font-weight: bold;color: black;">Historial de reproducciones</p>
                </div>
                <?php foreach ($history->list as $row) { ?>
                <div class="col-lg-12" style="background-color: white;
                     padding: 15px;
                     border-top: 1px solid rgb(242, 242, 242);">
                   <div class="col-lg-2" style="width: 130px">
                    <a href="<?php echo base_url(); ?>video/view/<?php echo $row->idVideo ?>">
                        <img src="http://img.youtube.com/vi/<?php echo $row->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
                    </a>
                   </div>
                    <div class="col-lg-10">
                        <a href="<?php echo base_url(); ?>video/view/<?php echo $row->idVideo ?>"><?php echo $row->videoName ?></a>
                        <p>De <?php echo $row->channelName ?><br>
                        <?php echo $row->videoViews ?> Visualizaciones
                        </p>
                        
                    </div>
                </div>
            <?php } ?>
            </div>
            
        <?php } ?>

        <?php $this->load->view('footer'); ?>
    </body>
