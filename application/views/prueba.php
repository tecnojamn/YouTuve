
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
        <div id="player"></div>
        <script type="text/javascript" id="www-widgetapi-script" src="https://s.ytimg.com/yts/jsbin/www-widgetapi-vfl3I-GuN/www-widgetapi.js" async=""></script>
        <script src="https://www.youtube.com/iframe_api"></script>
        <script>

            // 3. This function creates an <iframe> (and YouTube player)
            //    after the API code downloads.
            var player;
            function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                    height: '390',
                    width: '640',
                    videoId: 'M7lc1UVf-VE',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            // 4. The API will call this function when the video player is ready.
            function onPlayerReady(event) {
                event.target.playVideo();
            }

            // 5. The API calls this function when the player's state changes.
            //    The function indicates that when playing a video (state=1),
            //    the player should play for six seconds and then stop.
            function onPlayerStateChange(event) {
                if (event.data == 0) {
                    player.cueVideoById("u1zgFlCw8Aw", 10, "medium");
                }
            }
            function stopVideo() {
                player.stopVideo();
            }
        </script>
        <?php $this->load->view('footer'); ?>
    </body>
</html>