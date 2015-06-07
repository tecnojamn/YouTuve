
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
            var commentPage = 0;
            var commentsEnded = false;
            $(document).ready(function () {
                loadComments();
                //executes when user votes video
                $('#rater').on('change', function () {
                    var rate = $(this).val();
                    $.post("<?php echo base_url(); ?>video/rateAX", {rate: rate, vidId: "<?php echo $video->id; ?>"},
                    function (data) {
                        if (data.result === 'true') { //si el resultado es verdadero lo agrego
                            $("#rateHolder").css("font-size", "12px").html(data.html).hide().fadeIn();
                        }
                    }, "json");
                });
                $("#loadMoreComments").click(function (e) {
                    e.preventDefault();
                    if (!commentsEnded) {
                        loadComments();
                    }
                });
                function loadComments() {
                    commentPage++;
                    $.post("<?php echo base_url(); ?>comment/getCommentsAX", {page: commentPage, vidId: "<?php echo $video->id; ?>"},
                    function (data) {
                        if (data.result === 'true') { //si el resultado es verdadero lo agrego
                            $("#comments").append(data.html);
                        } else {
                            commentsEnded = true;
                            if ($(".videoComment").length === 0)
                                $("#comments").hide();
                            $("#loadMoreCommentsHolder").remove();
                        }
                    }, "json");
                }
<?php if ($log) { ?>
                    $("#submitComment").submit(function (e) {
                        e.preventDefault();
                        $("#comments").show();
                        var comment = $("#commentArea").val(); //chequear lenght >0 y menor a 150
                        $.post("<?php echo base_url(); ?>comment/saveCommentAX", {vidId: "<?php echo $video->id; ?>", commentText: comment}, function (data) {
                            if (data.result) {
                                $("#commentHolder").fadeOut(2000).remove();
                                $("#comments").hide().fadeIn(1500).prepend(data.html);
                            } else {
                            }
                        }, "json");
                    });
<?php } ?> $("#addToPlToggler").click(function (e) {
                    e.preventDefault();
                    $("#addToPlHolder").toggle();
                    if ($("#addToPlHolder").css("display") === "block") {
                        loadPls();
                    }
                });
                function loadPls() {
                    $.post("<?php echo base_url(); ?>playlist/getFromUserMinAX", function (data) {
                        if (data.result === "true") {
                            $("#addPlList").append(data.html);
                        }
                    }, "json");
                }
<?php if (!$isMyVideo) { ?>

                    $("#followHisAss").click(function (e) {
                        e.preventDefault();
                        //loader ON
                        $.post("<?php echo base_url(); ?>user/followChannelAX", {channel: "<?php echo $video->idChannel; ?>", userId: "<?php echo $userID; ?>"}, function (data) {
                            //loader OFF
                            $("#followHisAss").empty();
                            $("#followHisAss").attr("disabled", true);
                            if (data.result === 'true') {
                                $("#followHisAss").append(data.html).delay(2000).fadeOut(500);
                            } else {
                                $("#followHisAss").append(data.html).delay(2000).fadeOut(500);
                            }

                        }, "json");
                    });
                    $("#unfollowHisAss").click(function (e) {
                        e.preventDefault();
                        //loader ON
                        $.post("<?php echo base_url(); ?>user/unfollowChannelAX", {channel: "<?php echo $video->idChannel; ?>", userId: "<?php echo $userID; ?>"}, function (data) {
                            //loader OFF
                            $("#unfollowHisAss").empty();
                            if (data.result === 'true') {
                                $("#unfollowHisAss").attr("disabled", true);
                                $("#unfollowHisAss").append(data.html).delay(2000).fadeOut(500);
                            } else {
                                $("#unfollowHisAss").append(data.html).delay(2000).fadeOut(500);
                            }

                        }, "json");
                    });
<?php } ?>
            }
            );
        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <div class="col-lg-12">


            <div class="row">
                <div class="col-lg-12" >
                    <div id="thater" style="height:510px;background: black;">
                        <div class='col-lg-2' ></div>
                        <div>
                            <iframe style="padding: 0;"class="col-lg-8 text-center" width="100%" height="510" src="https://www.youtube.com/embed/<?php echo $video->link ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class='col-lg-2'></div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="col-lg-12" style=" ">

                    <div class="col-lg-8 " style="padding-left:0; ">
                        <div id="videoDataContainer" class="well well-red" style="  height: auto;
                             overflow: hidden;">
                            <div class="col-lg-2" style="">
                                <div id="presentation" class="circular1" style="  width: 55px;
                                     height: 55px;
                                     border-bottom: 8px dotted rgb(228, 111, 97);">
                                    <img   style="min-height: 100px;min-width: 100px;width: auto;max-width: 200px; max-height: 200px;" src="<?php echo $video->userthumb; ?>"/>
                                </div>
                            </div>
                            <div class="col-lg-10" style>
                                <h3 style="  margin: 0px 5px;"><?php echo $video->name; ?></h3>
                                <a href="<?php echo base_url() ?>channel/view/<?php echo $video->idChannel; ?>">
                                    <h3 style="  margin: 0px 5px;
                                        font-size: 12px;
                                        line-height: 22px;
                                        color: grey;"><?php echo $video->channelName; ?></h3></a>

                                <?php if (!$isMyVideo && !$follower && $log == 1) {
                                    ?>
                                    <a href="#" id="followHisAss" class="btn btn-primary btn-xs" style="
                                       font-size: 10px;">
                                        Seguir
                                    </a>
                                <?php } else if (!$isMyVideo && $follower && $log == 1) { ?>
                                    <a href="#" id="unfollowHisAss" class="btn btn-primary btn-xs" style="
                                       font-size: 10px;">Dejar de seguir</a>
                                   <?php } ?>
                            </div>
                            <?php if ($log == 1) { ?>
                                <div class="col-lg-12" id="commentHolder" style="margin-top: 20px;
                                     border-top: 5px solid rgb(63, 134, 255);
                                     background-color: rgb(118, 167, 250);
                                     padding: 20px;">
                                    <form id="submitComment">
                                        <div class="form-group">
                                            <textarea style=""  placeholder="Ingrese un comentario" type="text" class="form-control" id="commentArea"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-default">Comentar</button>
                                    </form>
                                </div> <?php } ?>
                        </div>

                        <div id="comments" class="well well-turq" style="padding: 2px 0px;  margin-bottom: 0;padding-bottom: 0;">
                            <!-- videos comments -->
                        </div>
                        <div id="loadMoreCommentsHolder" style="background-color: rgb(77, 191, 217);text-align: center;border-bottom: 2px solid rgb(65, 166, 189);margin-bottom: 20px;">
                            <a style="margin: 0 auto;text-align: center;
                               color: white;"href="#" id="loadMoreComments">Cargar más</a>
                        </div>


                    </div>

                    <div class="col-lg-4" style="  height: 100%;padding-right:0; ">
                        <div id="videoDataContainer" style="  overflow: hidden;"class="well well-blue">
                            <div style="  text-align: center;
                                 font-size: 20px;">
                                <p><?php echo $video->views ?> vista/s</p>
                            </div>
                            <?php
                            if ($video->rate <= 0) {
                                $video->rate = 1;
                            }
                            ?>
                            <div class="starHolder">
                                <p style="  font-size: 15px;color: rgb(218, 189, 43);">Valoración general: </p>
                                <input type="hidden" readonly="readonly" value="<?php echo $video->rate; ?>" class="rating"/>
                            </div>
                            <?php if ($log == 1) { ?>
                                <div id="rateHolder" class="starHolder sratHolder-alternativeColor">
                                    <p style="font-size: 15px;color: rgb(186, 55, 55)">Tu valoración: </p>
                                    <input id="rater" type="hidden" step="1" value="<?php echo $userRate; ?>" 
                                    <?php
                                    if ($userRate > 0) {
                                        echo 'disabled="disabled"';
                                    }
                                    ?>
                                           class = "rating"/>
                                </div>
                            <?php } ?>
                            <div style="  text-align: center;
                                 font-size: 20px;">
                                 <?php
                                 if ($video->tags !== null && $video->tags->list !== null) {
                                     foreach ($video->tags->list as $t) {
                                         ?>
                                        <div style="  margin: 0 5px;  border: 1px solid rgb(152, 74, 100);  width: 30%;float: left;font-size: 15px;background-color: rgb(188, 86, 121);color: white;padding: 5px;"> <?php echo $t->name; ?></div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="well well-red">
                            <a id="addToPlToggler" href="#">Agregar a playlist</a>
                            <div style="display:none" id="addToPlHolder">
                                <input id="addPlNewName" type="text" data-name="plname" name="Artigas"/>
                                <a href="#" id="addNewPl">Agregar nueva</a>
                                <ul id="addPlList">

                                </ul>
                            </div>
                        </div>
                        <div class="well  well-violet" id="featured_playlist" style="">
                            more videos DATA GOES HERE
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