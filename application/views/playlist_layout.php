
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
        <script>
            // This code loads the IFrame Player API code asynchronously.
            var tag = document.createElement('script');

            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            //This function creates an <iframe> (and YouTube player)
            //    after the API code downloads.
            var player;
            function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                    height: '390',
                    width: '640',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            //The API will call this function when the video player is ready.
            function onPlayerReady(event) {
                player.cueVideoById(videoLink, 1, "large");
                event.target.playVideo();
            }

            //The API calls this function when the player's state changes.
            function onPlayerStateChange(event) {
                if (event.data == 0) {
                    playNext();
                }
            }

        </script>
        <script>
            var id = '<?php echo $playlist->id ?>';
            var actualVideoId = 0;
            var videoLink = 0;
            var player;
            $(document).ready(function () {
                loadVideosPlaylist();
                actualVideoId = $('#videosContainer').children().first().children('input#id').val();
                videoLink = $('#videosContainer').children().first().children('input#link').val();

                $(".videoInfo").each(function (v) {
                    $(this).removeClass("col-lg-4").removeClass("well-violet");
                    $(this).removeClass("col-lg-12").css("overflow", "hidden").css("margin", "0")
                            .css('border-top', '1px solid #ECECEC');
                })
            });

            function loadVideosPlaylist() {
                $('#videosContainer').empty();
                $.ajax({
                    url: '<?php echo base_url() . "playlist/getVideosAx" ?>',
                    method: "POST",
                    async: false,
                    data: {idPlaylist: id},
                    success: function (data) {
                        $('#videosContainer').append(data.html);
                        $('.delVideo').bind('click', function () {
                            delVideo(event);
                        });
                        $('.changeVideo').bind('click', function () {
                            changeVideo(event);
                        });
                        $('.changeVideoImg').bind('click', function () {
                            changeVideoImg(event);
                        });
                    },
                    dataType: 'json'
                })
            }
            function changeVideo(event) {
                //obtiene el link del video
                videoLink = $(event.target).parent().parent().children('input#link').val();
                player.cueVideoById(videoLink, 1, "large");
                actualVideoId = $(event.target).parent().parent().children('input#id').val();
                player.playVideo();
            }
            function changeVideoImg(event) {
                //obtiene el link del video
                videoLink = $(event.target).parent().parent().parent().children('input#link').val();
                player.cueVideoById(videoLink, 1, "large");
                actualVideoId = $(event.target).parent().parent().children('input#id').val();
                player.playVideo();
            }
            function playNext() {
                var isNext = false; //indica si es el siguiente video 
                var auxId = 0;
                var lastId = $('#videosContainer').children().last().children('input#id').val();
                //Si el video es el ultimo vuelve al primero y lo deja en stop;
                if (lastId == actualVideoId) {
                    actualVideoId = $('#videosContainer').children().first().children('input#id').val();
                    videoLink = $('#videosContainer').children().first().children('input#link').val();
                    player.cueVideoById(videoLink, 1, "large");
                } else {
                    $('.videoInfo').each(function () {
                        auxId = $(this).children('input#id').val();
                        if (isNext) {
                            actualVideoId = auxId;
                            videoLink = $(this).children('input#link').val();
                            player.cueVideoById(videoLink, 1, "large");
                            player.playVideo();
                            isNext = false;
                            return;
                        }

                        if (auxId == actualVideoId) {
                            isNext = true;//asi en el proximo bucle cambia de video
                        }
                    });
                }
            }

            function delVideo(event) {
                //obtiene id del video
                var idVideoPlay = $(event.target).parent().parent().children('input#id').val();
                if (actualVideoId = idVideoPlay) {
                    playNext();
                }
                $.post('<?php echo base_url() ?>playlist/delVideoAx', {idPlaylist: id, idVideo: idVideoPlay}, function (data) {
                    $("body").append(data.html);
                    $("#messageBox").delay(1500).animate({opacity: "0.1"}, 500);
                    setTimeout(function () {
                        $('#messageBox').remove();
                    }, 2001);
                    loadVideosPlaylist();
                }, 'json');
            }

        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <?php if ($playlist !== null && $playlist->videos !== null) {
            ?>

            <div class="col-lg-12">
                <div style="  background-color: white;width: 100%;height: auto;overflow: hidden;padding: 15px 5px;">
                    <div class="col-lg-1"> <img style="width:100%;border: 1px solid rgb(213, 213, 213);" src="<?php echo $playlist_image ?>"/></div>
                    <div class="col-lg-11">
                        <p style="  font-size: 20px;line-height: 55px;font-weight: bold;color: black;"><?php echo $playlist->name ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="min-height: 400px;background-color: black;margin-bottom: 20px;padding-bottom: 15px;">
                <div class="col-lg-7" style="padding:0;">
                    <div id="player"></div>
                </div>
               
                <div id="videosContainer" class="col-lg-5" style="    padding: 0;
                     height: 400px;
                     background-color: #EAEAEA;
                     overflow-y: scroll;    overflow-x: hidden;">
                </div>
            </div>
        <?php } ?>

        <?php $this->load->view('footer'); ?>
    </body>
</html>