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
        <input type="hidden" id="orderBy" value="<?php echo $orderby ?>">
        <input type="hidden" id="tagId" value="<?php echo $tag ?>">
        <script>
            var orderBy = $('body').children('input#orderBy').val(); 
            var tag = $('body').children('input#tagId').val(); 
            var curr_page = 1;
            var paginator_ended = false;//fix para que no viaje
            //var can_load_more = true;//fix para que no viaje
            function loadMore() {
                curr_page = curr_page + 1;
                //can_load_more = false;
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>video/getMoreVideosAX",
                    data: {searchPage: curr_page, orderBy: orderBy, tag: tag},
                    success: function (data) {
                        if (data.result === 'true') { //si el resultado es verdadero lo agrego
                            $("#videosContent").append(data.html);
                        } else {
                            paginator_ended = true;
                        }
                    },
                    dataType: "json",
                    async: false
                });
            }
            function bindScroll() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    if (!paginator_ended)
                        loadMore();
                }
            }
            $(window).scroll(bindScroll);
        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row" style="padding: 0 15px;">
            <div class="col-lg-12" style="padding:0 15px;" id="videos">
                <div class = "col-lg-12 well" style = "overflow: hidden;
                     background-color: transparent;
                     border: none;
                     min-height: 800px;" id="videosContent">
                     <?php
                     if ($searched_videos !== NULL && count($searched_videos->list) > 0) {
                         foreach ($searched_videos->list as $video) {
                             ?>
                            <div class = "col-lg-12 well well-red" style = "overflow: hidden;">
                                <div class = "col-lg-3">
                                    <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
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
                    } else {
                        ?>
                        <div class="alert alert-dismissible alert-warning">
                            No videos to display</div>
                    <?php }
                    ?>
                </div>
            </div>  
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>