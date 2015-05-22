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
    </head>

    <body>
        <script>
            $(document).ready(function () {
<?php if ($profile === "me") { ?>
                    //EDIT MODAL
                    $("#editBtn").click(function () {
                        $("#editModal").modal("show");
                        console.log($('#editModal').find("#editFormHolder").data("loaded"));
                        //si el form no esta cargado lo vamos a buscar con AX
                        if ($('#editModal').find("#editFormHolder").data("loaded") === false) {
                            $.get("<?php echo base_url(); ?>AXForm/formUserEditInfo", function (data) {
                                if (data.result) {
                                    //si el resultado es verdadero lo agrego
                                    $("#editFormHolder").append(data.html);
                                    $('#editModal').find("#editFormHolder").data("loaded", "true")
                                }
                            }, "json");

                        }
                    })
                    $('#closeEditModal').click(function () {
                        $('#editModal').modal('hide');
                    });
<?php } ?>

            });
        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row" >
            <div id="editModal" style="display:none" class="modal">
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

            <div id="presentation" class="col-lg-12" style="background: url('<?php echo base_url(); ?>css/images/default_cover.jpg')no-repeat fixed center;   background-size: 1100px 100%;
                 padding: 0px 30px;
                 height: 280px;">
                 <?php
                 if (isset($error) && $error) {
                     ?>
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                    <?php
                }
                ?>
                <div id="presentation-holder"class="col-lg-4" style="height: 280px;
                     background: rgba(0, 0, 0, 0.8);">
                    <div id="presentation" class="col-lg-12" style="padding:60px 40px;">
                        <div id="presentation" class="circular1">
                            <img src="<?php echo $user_data->thumbUrl; ?>" />
                            <?php if ($profile === "me") { ?>
                                <div id="cam"></div>
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
                    <ul style=" width: 400px;list-style-type: none;margin: 0;padding: 0;margin:0 auto; list-style: none;">
                        <li aria-expanded="true" data-toggle="tab"  href="#about_me" class="selected active" style="display: inline;"><a aria-expanded="true" data-toggle="tab"  href="#about_me">Sobre Mi</a></li>
                        <li aria-expanded="false" data-toggle="tab"  href="#my_channel" style="display: inline;"><a aria-expanded="false" data-toggle="tab"  href="#my_channel">Mi Canal</a></li>
                        <li aria-expanded="false" data-toggle="tab"  href="#my_lists" style="display: inline;"><a aria-expanded="false" data-toggle="tab"  href="#my_lists">Mis Listas</a></li>

                    </ul>   

                </div>
            </div>

        </div>
        <div class="row" style=" padding: 15px 25px;">
            <div class="well well-lg  well-blue col-lg-12">
                <div id="profile-content" class="tab-content">
                    <div class="tab-pane fade  active in" id="about_me" style="font-size: 20px;line-height: 50px;">
                        <!--esto sin ajax pero lo otro estaria bueno que lo cargue con ajax-->
                        <p>Nick: <?php echo $user_data->nick; ?></p>
                        <p>Email: <?php echo $user_data->email; ?></p>
                        <p>Nombre: <?php echo $user_data->name; ?></p>
                        <p>Apellido: <?php echo $user_data->lastname; ?></p>
                        <p>Fecha de nacimiento: <?php echo $user_data->birthday; ?></p>
                        <p>Sexo: <?php echo ($user_data->gender === '1') ? "Hombre" : "Mujer"; ?></p>
                        <?php if ($profile === "me") { ?>
                            <a id="editBtn" href="#" style="font-size:15px">Editar</a>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="my_channel">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="my_lists">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>