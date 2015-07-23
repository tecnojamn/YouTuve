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
            var paginator_ended_channel = false;//fix para que no viaje
            var can_load_more_video = true;//fix para que no viaje
            var curr_page_channel = 1;
            var can_load_more_channel = true;//fix para que no viaje
            var active_option = "video";//fix para que no Vieja
            var can_load_more_video = true;//fix para que no viaje
            var curr_page_channel = 1;
            function loadMoreVideos() {
                curr_page_video = curr_page_video + 1;
                can_load_more_video = false;
                can_load_more_video = false;
                curr_page_video = curr_page_video + 1;
                $.post("<?php echo base_url(); ?>video/searchMoreVideosAX", {searchPage: curr_page_video, searchText: '<?php echo $searched_query ?>'},
                function (data) {
                    if (data.result === 'true') { //si el resultado es verdadero lo agrego
                        $("#videos").append(data.html);
                        can_load_more_video = true;
                    } else {
                        paginator_ended_video = true;
                        can_load_more_video = true;
                        can_load_more_video = false;
                    }
                }, "json");
            }
            function loadMoreChannels() {
                curr_page_channel = curr_page_channel + 1;
                can_load_more_channel = false;
                $.post("<?php echo base_url(); ?>channel/searchMoreChannelAX", {searchPage: curr_page_video, searchText: '<?php echo $searched_query ?>'},
                function (data) {
                    if (data.result === 'true') { //si el resultado es verdadero lo agrego
                        $("#channels").append(data.html);
                    } else {
                        paginator_ended_channel = true;
                        can_load_more_channel = true;
                        can_load_more_channel = false;
                        curr_page_channel = curr_page_channel + 1;
                        console.log(curr_page_channel);
                        $.post("<?php echo base_url(); ?>channel/searchMoreChannelAX", {searchPage: curr_page_channel, searchText: '<?php echo $searched_query ?>'},
                        function (data) {
                            if (data.result === 'true') { //si el resultado es verdadero lo agrego
                                $("#channels").append(data.html);
                                can_load_more_channel = true;
                            } else {
                                can_load_more_channel = false;
                            }
                        }, "json");
                    }
                });
            }
            function bindScroll() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    if (active_option === "video")
                    {
                        if (!paginator_ended_video && can_load_more_video) {
                            loadMoreVideos();
                        }
                    } else if (active_option === "channel")
                    {
                        if (!paginator_ended_channel && can_load_more_channel) {
                            if (can_load_more_video) {
                                loadMoreVideos();
                            }
                        } else if (active_option === "channel") {
                            if (can_load_more_channel) {
                                loadMoreChannels();
                            }
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
<?php }
?>
                    </div>
                    <div class="col-lg-12" style="padding:0 15px;" id="channels">

                        <?php
                        if ($searched_channels != null && $searched_channels->list != null) {
                            ?> <div class = "col-lg-12 well" style = "overflow: hidden;
                                 background-color: transparent;
                                 border: none;
                                 min-height: 800px;">

    <?php foreach ($searched_channels->list as $c) {
        ?>
                                    <div class="col-lg-12 well well-green" style="  height: auto;
                                         overflow: hidden;
                                         padding: 20px;
                                         margin-bottom: 20px;">
                                        <div style="  padding: 10px;"class="col-lg-10">
                                            <p style="  font-size: 16px;
                                               font-weight: bold;"><a href="<?php echo base_url(); ?>Channel/view/<?php echo $c->id ?>"><?php echo $c->name ?></a></p>
                                            <p><?php echo $c->description ?></p>
                                        </div>
                                        <div class="col-lg-2">
                                            <a  href="<?php echo base_url(); ?>channel/view/<?php echo $c->id ?>">
                                                <img style="width:100%;border: 1px solid rgb(213, 213, 213);" src="<?php echo $c->frontImgUrl ?>"/></a>
                                        </div>
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
                                <div class = "col-lg-12 well well-red" style = "overflow: hidden;">
                                    La busqueda concluyo sin canales
                                </div>
                            </div>
<?php }
?>
                    </div>
               
<?php $this->load->view('footer'); ?>
                </body>
                </html>