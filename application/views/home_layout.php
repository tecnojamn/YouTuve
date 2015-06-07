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
        <script>
            $(document).ready(function () {
                //carga videos mas nuevos
                $.post("<?php echo base_url(); ?>video/getVideosAx",
                        {orderBy: 'date'},
                function (data) {
                    if (data.result === 'true') {
                        $("#lastVideos").hide().fadeIn(1000).append(data.html);
                    }
                }, "json");
                //carga videos mas votados
                $.post("<?php echo base_url(); ?>video/getVideosAx",
                        {orderBy: 'rate'},
                function (data) {
                    if (data.result === 'true') {
                        $("#topVideos").hide().fadeIn(2200).append(data.html);
                    }
                }, "json");

<?php if (isset($log) && $log) { ?>
                    //carga videos del canal del usuario
                    $.post("<?php echo base_url(); ?>video/getVideosAx  ",
                            {channelVideos: 'true'},
                    function (data) {

                        $("#channelVideos").hide().fadeIn(3500).append(data.html);

                    }, "json");
<?php } ?>
            });
        </script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row" style="
             padding: 0 30px;
             ">
            <div id="lastVideos" class="well well-blue" style="width: 100%;float: left;  background-color: #f8f8f8;">
                <p style="  margin: 15px 40px;
                   padding-bottom: 5px;
                   border-bottom: 1px solid #eeeeee;
                   font-size: 18px;
                   position: relative;">Ultimos Videos</p>
                <a style="  float: right;
                   position: relative;
                   top: -40px;
                   left: -50px;" href="<?php echo base_url(); ?>video/showList?orderBy=date" style="float: right">Ver mas</a>
            </div></div>
        <div class="row"style="
             padding: 0 30px;
             "> <div id="topVideos"  class="well well-green" style="width: 100%;float: left;  background-color: #f8f8f8;">
                <p style="  margin: 15px 40px;
                   padding-bottom: 5px;
                   border-bottom: 1px solid #eeeeee;
                   font-size: 18px;
                   position: relative;">Top Videos</p>
                <a  style="  float: right;
                    position: relative;
                    top: -40px;
                    left: -50px;" href="<?php echo base_url(); ?>video/showList?orderBy=rate" style="float: right">Ver mas</a>
            </div></div>
        <?php if (isset($log) && $log) { ?>
            <div class="row"style="
                 padding: 0 30px;
                 "> <div id="channelVideos" class="well well-yellow" style="width: 100%;float: left;  background-color: #f8f8f8;">
                    <p style="  margin: 15px 40px;
                       padding-bottom: 5px;
                       border-bottom: 1px solid #eeeeee;
                       font-size: 18px;
                       position: relative;">Videos de Canales que Sigues</p>

                </div></div>
        <?php } ?>
        <?php $this->load->view('footer'); ?>

    </body>
</html>