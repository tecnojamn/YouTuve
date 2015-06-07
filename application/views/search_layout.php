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
        <script>
            var curr_page_video = 1;
            var paginator_ended_video = false;//fix para que no viaje
            var can_load_more_video = true;//fix para que no viaje

            var curr_page_channel = 1;
            var paginator_ended_channel = false;//fix para que no viaje
            var can_load_more_channel = true;//fix para que no viaje

            var active_option = "video";//fix para que no Vieja
            function loadMoreVideos() {
                curr_page_video = curr_page_video + 1;
                can_load_more_video = false;
                $.post("<?php echo base_url(); ?>video/searchMoreVideosAX", {searchPage: curr_page_video, searchText: '<?php echo $searched_query ?>'},
                function (data) {
                    if (data.result === 'true') { //si el resultado es verdadero lo agrego
                        $("#videos").append(data.html);
                    } else {
                        paginator_ended_video = true;
                        can_load_more_video = true;
                    }
                }, "json");
            }

            function loadMoreChannels() {
                curr_page_channel = curr_page_channel + 1;
                can_load_more_channel = false;
                $.post("<?php echo base_url(); ?>video/searchMoreChannelAX", {searchPage: curr_page_video, searchText: '<?php echo $searched_query ?>'},
                function (data) {
                    if (data.result === 'true') { //si el resultado es verdadero lo agrego
                        $("#channels").append(data.html);
                    } else {
                        paginator_ended_channel = true;
                        can_load_more_channel = true;
                    }
                }, "json");
            }
            function bindScroll() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    if (active_option === "video") {
                        if (!paginator_ended_video && can_load_more_video) {
                            loadMoreVideos();
                        }
                    } else if (active_option === "channel") {
                        if (!paginator_ended_channel && can_load_more_channel) {
                            loadMoreChannels();
                        }
                    }
                }
            }

            $(window).scroll(bindScroll);

            $(document).ready(function () {
                $("#channels").hide();
                $("#videoBtn").click(function () {
                    $("#videos").show();
                    $("#channels").hide();
                    active_option = "video";
                });
                $("#channelBtn").click(function () {
                    $("#channels").show();
                    $("#videos").hide();
                    active_option = "channel";
                });
            });
        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="col-lg-12">
            <div id="profile-nav" style="height: 40px;
                 background: rgb(255, 255, 255);
                 padding: 0px 15px;">
                <ul style=" width: 400px;list-style-type: none;margin: 0;padding: 0;margin:0 auto; list-style: none;">
                    <li  data-toggle="tab"   class="active" style="display: inline;" id="videoBtn"><a data-toggle="tab"  href="#" >Videos</a></li>
                    <li  data-toggle="tab"   style="display: inline;" id="channelBtn"><a  data-toggle="tab"   href="#" >Canales</a></li>

                </ul>   

            </div>
        </div>
        <div class="row">
            <div class="col-lg-8" id="videos">
                <?php
                if ($searched_videos) {
                    foreach ($searched_videos->list as $video) {
                        ?>
                        <div class="col-lg-12" style="border: 1px solid rgb(216, 216, 216);background-color: white;padding: 12px;margin-bottom: 12px;">
                            <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                                <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
                            </a>
                            <label ><?php echo $video->name ?></label> <br>
                            <a href="#" ><?php echo $video->channelName ?></a> <br>
                            <label >Publicado el <?php echo $video->date ?></label>
                        </div>
                        <?php
                    }
                } else {
                    echo "No hat videos para mostrar";
                }
                ?>
            </div>
            <div class="col-lg-8" id="channels">
                <?php
                if ($searched_channels) {
                    foreach ($searched_channels->list as $channel) {
                        ?>
                        <div class="col-lg-12" style="border: 1px solid rgb(216, 216, 216);background-color: white;padding: 12px;margin-bottom: 12px;">
                            <a href="<?php echo base_url(); ?>channel/view/<?php echo $channel->id ?>">
                                <img src="<?php echo $channel->frontImgUrl ?>" style="width: 100px;height: 100px;float: left;" alt="<?php echo $channel->name ?>">
                            </a>
                            <label ><?php echo $video->name ?></label> <br>
                            <a href="#" ><?php echo $video->channelName ?></a> <br>
                            <label >Publicado el <?php echo $video->date ?></label>
                        </div>
                        <?php
                    }
                } else {
                    echo "No hay canales para mostrar";
                }
                ?>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>