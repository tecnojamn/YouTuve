<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootswatch.less">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!--Calendar-->
        <link href="<?php echo base_url(); ?>css/calendar/css/calendario.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>css/calendar/js/calendario.js" type="text/javascript"></script>
    </head>

    <body>

        <?php if ($profile === "me") { ?>
            <script>
                var plPage = 0;
                var plFirstLoad = 0;
                var plEnd = 0;
                var chFirstLoad = 0;
                $(document).ready(function () {
                    $("#listLoaderTrigger").click(function () {

                        if (plFirstLoad === 0) {

                            plFirstLoad = 1;
                            $.get("<?php echo base_url(); ?>Playlist/getFromUserAX", function (data) {
                                if (data.result === 'true') {
                                    $("#my_lists .progress").delay(1000).hide();
                                    $("#listHolder").append(data.html);
                                } else {

                                    $("#my_lists .progress").delay(1000).hide();
                                    $("#listHolder").append("No hay listas para mostrar");
                                }

                            }, "json");
                        }

                    });
                    $("#channelLoaderTrigger").click(function () {

                        if (chFirstLoad === 0) {

                            chFirstLoad = 1;
                            $.get("<?php echo base_url(); ?>Channel/getFromUserAX", function (data) {
                                if (data.result === 'true') {
                                    $("#my_channel .progress").delay(1000).hide();
                                    $("#channelHolder").append(data.html);
                                } else {
                                    $("#my_channel .progress").delay(1000).hide();
                                    $("#channelHolder").append("No hay Canales para mostrar");
                                }
                            }, "json");
                        }

                    });
                    //LOAD EDIT MODAL
                    $("#editBtn").click(function () {
                        $("#editModal").modal("show");
                        console.log($('#editModal').find("#editFormHolder").data("loaded"));
                        //si el form no esta cargado lo vamos a buscar con AX
                        if ($('#editModal').find("#editFormHolder").data("loaded") === false) {
                            $.post("<?php echo base_url(); ?>AXForm/formUserEditInfo",
                            {
                                name: "<?php echo $user_data->name;?>" ,
                                lastname:"<?php echo $user_data->lastname;?>",
                                birthday:"<?php echo $user_data->birthday;?>",
                                gender:"<?php echo $user_data->gender;?>",
                            },
                            function (data) {
                                if (data.result) {
                                    //si el resultado es verdadero lo agrego
                                    $("#editFormHolder").append(data.html);
                                    $('#editModal').find("#editFormHolder").data("loaded", "true")
                                }
                            }, "json");
                        }
                    });
                    //LOAD EDIT THUMB MODAL
                    $("#cam").click(function () {
                        $("#editThumbModal").modal("show");
                        console.log($('#editThumbModal').find("#editThumbHolder").data("loaded"));
                        if ($('#editThumbModal').find("#editThumbHolder").data("loaded") === false) {
                            $.get("<?php echo base_url(); ?>AXForm/formUserEditThumb", function (data) {
                                if (data.result) {
                                    //si el resultado es verdadero lo agrego
                                    $("#editThumbHolder").append(data.html);
                                    $('#editThumbModal').find("#editThumbHolder").data("loaded", "true")
                                }
                            }, "json");
                        } else {
                            $("#errorThumbForm").hide();
                        }


                    });
                    //UPLOAD IMAGE
                    $(document).on('submit', '#uploadimage', function (e) {
                        e.preventDefault();
                        var formData = new FormData($(this)[0]);
                        $.ajax({
                            url: "<?php echo base_url(); ?>user/uploadThumb",
                            type: "POST",
                            data: formData,
                            async: true,
                            complete: function (data) {
                                console.log(data);
                                var data = data.responseJSON;
                                if (data.error === false) {
                                    $("#editThumbModal").modal("hide");
                                    $("mainMsgDisplay").show().removeClass("alert-danger").addClass("alert-success").prepend("Image Uploaded");
                                    $src = $(".circular1 img").attr("src");
                                    $(".circular1 img").removeAttr("src").attr("src", $src + "?" + new Date().getTime());
                                } else {
                                    $("#errorThumbForm").show();
                                    $("#errorThumbForm #msg").addClass("alert-danger").html(data.error_msg);
                                }
                            },
                            dataType: "json",
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                        /*$.post("<?php echo base_url(); ?>user/uploadThumb", formData, function (data) {
                         if (!data.error) {
                         
                         $("mainMsgDisplay").show().removeClass("alert-danger").addClass("alert-success").prepend("Image Uploaded");
                         } else {
                         $("#errorThumbForm").show();
                         $("#errorThumbForm #msg").addClass("alert-danger").html(data.error_msg);
                         }
                         }, "json");*/
                        return false;
                    });
                });
            </script>
        <?php } ?>


        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row" >

            <div id="presentation" class="col-lg-12" style="background: url('<?php echo base_url(); ?>css/images/default_cover.jpg')no-repeat fixed center;   background-size: 1100px 100%;
                 padding: 0px 30px;
                 height: 280px;">
                 <?php
                 if (isset($error) && $error) {
                     ?>
                    <div id="mainMsgDisplay" class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                    <?php
                }
                ?>
                <div id="presentation-holder"class="col-lg-4" style="height: 280px;
                     background: rgba(0, 0, 0, 0.8);">
                    <div id="presentation" class="col-lg-12" style="padding:60px 40px;">
                        <div id="presentation" class="circular1">
                            <img   style="min-height: 100px;
                                   min-width: 100px;
                                   width: auto;
                                   max-width: 200px;
                                   max-height: 200px;" src="<?php echo $user_data->thumbUrl; ?>" />
                                   <?php if ($profile === "me") { ?>
                                <div data-toggle="editThumbModal" id="cam"></div>
                            <?php } ?>

                        </div>
                        <div id="nick_holder" style="  text-align: center;
                             color: white;
                             font-size: 25px;
                             padding: 15px;">
                            <p><?php echo $user_data->nick; ?></p> 
                        </div>
                        <?php if ($profile === "alien") { ?>
                            <a href="#" class="btn btn-primary" style="
                               width: 100%;
                               margin-top: -20px;
                               ">Seguir a  <?php echo $user_data->nick; ?></a>
                           <?php } ?>
                    </div>
                </div>

            </div>
            <div class="col-lg-12">
                <div id="profile-nav" style="height: 40px;
                     background: rgb(255, 255, 255);
                     padding: 0px 15px;">
                    <ul style=" width: 500px;list-style-type: none;margin: 0;padding: 0;margin:0 auto; list-style: none;">
                        <li aria-expanded="true" data-toggle="tab"  href="#about_me" class="selected active" style="display: inline;"><a aria-expanded="true" data-toggle="tab"  href="#about_me">Sobre Mi</a></li>
                        <li id="channelLoaderTrigger" aria-expanded="false" data-toggle="tab"  href="#my_channel" style="display: inline;"><a aria-expanded="false" data-toggle="tab"  href="#my_channel">Suscripciones</a></li>
                        <li id="listLoaderTrigger" aria-expanded="false" data-toggle="tab"  href="#my_lists" style="display: inline;"><a aria-expanded="false" data-toggle="tab"   href="#my_lists">Mis Listas</a></li>

                    </ul>   

                </div>
            </div>

        </div>
        <div class="row" style=" padding: 15px 25px;">
            <div class="well well-lg  well-blue col-lg-12">
                <div id="profile-content" class="tab-content">
                    <div class="tab-pane fade  active in" id="about_me" style="font-size: 20px;line-height: 50px;">
                        <!--esto sin ajax pero lo otro estaria bueno que lo cargue con ajax-->
                        <table class="table table-condensed">
                            <tr>
                                <td>Nick:</td>
                                <td><?php echo $user_data->nick; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><?php echo $user_data->email; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre:</td>
                                <td><?php echo $user_data->name; ?></td>
                            </tr>
                            <tr>
                                <td>Apellido:</td>
                                <td><?php echo $user_data->lastname; ?></td>
                            </tr>
                                <td>Fecha de nacimiento:</td>
                                <td><?php echo date('d/m/Y', strtotime($user_data->birthday)); ?></td>
                            </tr>
                            <tr>
                                <td>Sexo:</td>
                                <td><i class="fa <?php echo $user_data->gender==='0'?"fa-mars":"fa-venus";?>" ></i> <?php echo ($user_data->gender === '0') ? "Hombre" : "Mujer"; ?></td>
                            </tr>
                        </table>
                        <?php if ($profile === "me") { ?>
                            <a data-toggle="editModal" id="editBtn" class="btn btn-primary" href="#" style="font-size:15px">Editar Datos</a>
                            <a style="font-size:15px" class="btn btn-primary" href="<?php echo base_url(); ?>user/changePassForm">Cambiar Contraseña</a>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="my_channel">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                        <div id="channelHolder">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="my_lists">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                        <div id="listHolder">

                        </div>
                    </div>
                </div>
            </div>


            <div id="editModal" style="display:none" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="false">×</button>
                            <h4 class="modal-title">Editar Información Básica</h4>
                        </div>
                        <div id="editFormHolder" data-loaded="false" class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
            <div id="editThumbModal" style="display:none" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="false">×</button>
                            <h4 class="modal-title">Editar Imagen</h4>
                        </div>
                        <div id="editThumbHolder" data-loaded="false" class="modal-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>