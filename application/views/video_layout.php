
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

        <div class="col-lg-12">


            <div class="row">
                <div class="col-lg-12" >
                    <div id="thater" style="height:510px;background: black;">
                        <div class='col-lg-2' ></div>
                        <div>
                            <iframe style="padding: 0;"class="col-lg-8 text-center" width="100%" height="510" src=<?php echo "https://www.youtube.com/embed/" . $video->link ?> frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class='col-lg-2'></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style=" ">
                    <div class="well" id="user_data" style=" 
                         margin-top: 20px;
                         height: 140px;">
                        USER AND VIDEO DATA GOES HERE
                        <br><?= $video->name ?>
                        <br><?= $video->rate ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="margin-top: 20px;">
                    <div class="col-lg-8" style="padding-left: 0;">
                        <div id="comments" class="well" style=" height:500px;">
                            COMMENTS DATA GOES HERE
                            <div id="ejemplo" style="
                                 padding: 10px;
                                 border: 1px solid rgb(229, 229, 229);
                                 background: white;
                                 height: 72px;
                                 ">
                                <div class="col-lg-12" style="">
                                    <div class="col-lg-2" style="padding-left: 0;">
                                        <img style="width:50px" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/c0.0.160.160/p160x160/11009192_818517381568817_4645766960803896127_n.jpg?oh=76456d90d26ef050646244f30e606847&amp;oe=55C5D0C6&amp;__gda__=1443308820_eb0829a1b3510729d754bd28251cc1b0"> 
                                    </div>
                                    <div class="col-lg-10" style="padding-left: 0;">
                                        <div style="padding: 0 20px;">
                                            Que buen video, lastima la página, que es una copia re trucha de otra página.
                                        </div> 
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div> 
                    <div class="col-lg-4" style="padding-right: 0;">
                        <div class="well" id="featured_playlist" style=" height:500px;">
                            PLAYLIST DATA GOES HERE
                            <div id="ejemplo" style="
                                 padding: 10px;
                                 border: 1px solid rgb(229, 229, 229);
                                 background: white;
                                 height: 72px;
                                 ">
                                <div class="col-lg-12" style="">
                                    <div class="col-lg-2" style="padding-left: 0;">
                                        <img style="width:50px" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/c0.0.160.160/p160x160/11009192_818517381568817_4645766960803896127_n.jpg?oh=76456d90d26ef050646244f30e606847&amp;oe=55C5D0C6&amp;__gda__=1443308820_eb0829a1b3510729d754bd28251cc1b0"> 
                                    </div>
                                    <div class="col-lg-10" style="padding-left: 0;">
                                        <div style="padding: 0 20px;">
                                            Video Nombre
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> 
                </div>
            </div>
            <?php echo (isset($error) && $error == 1) ? $error_message : ""; ?>
            <?php $this->load->view('footer'); ?>
    </body>
</html>