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
                        $("#lastVideos").append(data.html);
                    }
                }, "json");
                //carga videos mas votados
                $.post("<?php echo base_url(); ?>video/getVideosAx",
                        {orderBy: 'rate'},
                function (data) {
                    if (data.result === 'true') {
                        $("#topVideos").append(data.html);
                    }
                }, "json");
                
                    <?php if (isset($log) && $log) { ?>
                        //carga videos del canal del usuario
                        $.post("<?php echo base_url(); ?>video/getVideosAx  ",
                                {channelVideos: 'true'},
                        function (data) {
                            if (data.result === 'true') {
                                $("#channelVideos").append(data.html);
                            }
                        }, "json");
                    <?php } ?>
            });
        </script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <div id="lastVideos" style="width: 100%;float: left;">
            Ultimos Videos
            <a href="<?php echo base_url();?>video/showList?orderBy=top" style="float: right">Ver mas</a>
        </div>
        <div id="topVideos" style="width: 100%;float: left;">
            Top Videos
            <a href="#" style="float: right">Ver mas</a>
        </div>
        <div id="channelVideos" style="width: 100%;float: left;">
            Videos de canales que sigues 

        </div>

        <?php $this->load->view('footer'); ?>

    </body>
</html>