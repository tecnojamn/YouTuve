
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
            var id = '<?php echo $playlist->id ?>';
            $(document).ready(function () {
                loadVideosPlaylist();
            });
            function loadVideosPlaylist() {
                $('#videosContainer').empty();
                $.post('<?php echo base_url() . "playlist/getVideosAx" ?>', {idPlaylist: id}, function (data) {
                    $('#videosContainer').append(data.html);
                    $('.delVideo').bind('click', function (event) {
                        delVideo(event);
                    });
                }, 'json');
            }
            function delVideo(event) {
                var idVideoPlay = $(event.target.nextElementSibling).val();
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
            <div id="videosContainer" class="col-lg-12" style="min-height: 800px;background-color: rgb(219, 219, 219);margin-bottom: 20px;padding-bottom: 15px;">

            </div>
        <?php } ?>

        <?php $this->load->view('footer'); ?>
    </body>
</html>