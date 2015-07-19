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
    <body >
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <?php
        if(isset($_GET["msg"])){ 
            $success= $_GET["msg"] == "success"?  true: false;
            ?> <div class="row" style="min-height:50px;">
                <div class="col-lg-12">
                    <div class="alert alert-dismissible <?php echo $success? "alert-success": "alert-danger"; ?> "><button type="button" class="close" data-dismiss="alert">×</button>
           <?php   echo $success? "El video ha sido eliminado":"Error al eliminar el video"; ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <?php
        if (isset($error) && $error && isset($error_message) && $error_message !== "") {
            ?> <div class="row" style="min-height:800px;">
                <div class="col-lg-12">
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div></div></div>
            <?php
        }
        ?>
        <?php if ($channel !== null && $channel->videos !== null) {
            ?>
            <div class="col-lg-12">
                <div style="  background-image: url(<?php echo base_url() . ALT_CHANNEL_BACKGROUND_PIC; ?>);color: #f8f8f8;width: 100%;height: auto;overflow: hidden;padding: 15px 5px;">
                    <div class="col-lg-1"> <img style="width:100%;border: 1px solid rgb(213, 213, 213);" src="<?php echo base_url() . ALT_PLAYLIST_PIC//$channel->frontImgUrl          ?>"/></div>
                    <div class="col-lg-11">
                        <p style="  font-size: 20px;line-height: 55px;font-weight: bold;color: white;"><?php echo $channel->name ?></p>
                    </div>
                </div>
                <div style="background-color: white;width: 100%;height: auto;overflow: hidden; border-top: 1px solid rgb(242, 242, 242); padding: 15px">
                    <p><?php echo $channel->description ?></p>
                </div>
                <div style="background-color: white;width: 100%;height: auto;overflow: hidden; border-top: 1px solid rgb(242, 242, 242); padding: 15px">
                    <p><?php echo $channel->followersCount ==1 ?  $channel->followersCount." suscripción" : $channel->followersCount." suscripciones";  ?></p>
                </div>
                <div style="  font-size: 20px;background-color:white; "class="col-lg-12">
                    <p>Videos:</p>
                </div>
            </div>

            <div class="col-lg-12" style="background-color: rgb(219, 219, 219);margin-bottom: 20px;padding-bottom: 15px;">
                <?php foreach ($channel->videos->list as $v) { ?>
                    <div class="col-lg-12 well-blue" style="background-color: white;
                         padding: 15px;
                         border-top: 1px solid rgb(242, 242, 242);">
                        <div class="col-lg-2" style="width: 130px">
                            <a href="<?php echo base_url(); ?>video/view/<?php echo $v->id ?>">
                                <img src="http://img.youtube.com/vi/<?php echo $v->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
                            </a>
                        </div>
                        <div class="col-lg-10">
                            <a href="<?php echo base_url(); ?>video/view/<?php echo $v->id ?>"><?php echo $v->name ?></a><br>
                            <a href="<?php echo base_url(); ?>channel/view/<?php echo $channel->id ?>"><?php echo $channel->name ?></a><br>
                            <p>
                                <?php echo $v->views ?> Visualizaciones
                            </p>
                            <?php 
                            $id=$this->uri->segment(3, 0);
                            if($id=="me"){
                                echo "<a href='".base_url()."video/remove/".$v->id."'>Eliminar video</a>";
                                //echo "<a href='"+ base_url(); +"channel/view" + "'>"+ $channel->id +"</a><br>";                                
                            }   
                            ?>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>

        <?php }$this->load->view('footer'); ?>
    </body>
</html>

