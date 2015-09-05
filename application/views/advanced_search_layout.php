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
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body>

        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <div class="row" style="padding: 0 15px;">


            <div class="col-lg-12" style="margin-bottom: 10px;">
                <div id="profile-nav" style="height: 40px;
                     background: rgb(255, 255, 255);
                     padding: 0px 15px;">
                    <ul style=" width: 250px;list-style-type: none;margin: 0;padding: 0;margin:0 auto; list-style: none;">
                        <li  data-toggle="tab"   class="active" style="display: inline;" id="videoBtn"><a data-toggle="tab"  href="#" >Videos</a></li>
                        <li  data-toggle="tab"   style="display: inline;" id="channelBtn"><a  data-toggle="tab"   href="#" >Canales</a></li>

                    </ul>   

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="padding:0 15px;" id="videos">


                    <?php if ($searched_videos) { ?>
                        <div class = "col-lg-12 well" style = "overflow: hidden;
                             background-color: transparent;
                             border: none;
                             min-height: 800px;">


                            <?php
                            foreach ($searched_videos->list as $video) {
                                ?>

                                <div class = "col-lg-12 well well-red" style = "overflow: hidden;">
                                    <div class = "col-lg-3">
                                        <a href = "<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                                            <img src = "http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style = "width:100%">
                                        </a></div>
                                    <div class = "col-lg-9"><label ><?php echo $video->name
                                ?></label> <br>
                                        <a href="<?php echo base_url(); ?>channel/view/<?php echo $video->idChannel ?>"> <?php echo $video->channelName ?> </a> <br>
                                        <label >Publicado el <?php echo $video->date ?></label> <br>
                                        <label ><?php echo $video->views ?> Visualizaciones</label></div>
                                </div>
                                <?php
                            }
                            ?></div><?php
                    } else {
                        ?>

                        <div class = "col-lg-12 well" style = "overflow: hidden;
                             background-color: transparent;
                             border: none;
                             min-height: 800px;">
                            <div class = "col-lg-12 well well-yellow" style = "overflow: hidden;">
                                La busqueda concluyo sin videos
                            </div>
                        </div>

                    <?php } ?>
                    <?php $this->load->view('footer'); ?>
                    </body>
                    </html>