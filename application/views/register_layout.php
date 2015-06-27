
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
        <!-- estilo formulario -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
        <link href="<?php echo base_url(); ?>css/calendar/css/calendario.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>css/calendar/js/calendario.js" type="text/javascript"></script>

        <script type="text/javascript">
            function animateForm() {
                $("#regFormHolder").css("top", "-1000px").animate({
                    top: "0",
                }, 2000);

                $(".alert").hide().fadeIn(2000);
            }
            $(document).ready(function () {
                animateForm();

            });

            $(function () {
                $("#birthday").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "<?php echo base_url(); ?>/css/calendar/css/images/ico.png",
                    buttonImageOnly: true,
                    showButtonPanel: true,
                })
            })
        </script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row">

            <div class="col-lg-4"></div>
            <div class="col-lg-4 col-lg-offset-0 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">

                <?php
                if (isset($error) && $error && isset($error_message) && $error_message !== "") {
                    ?>
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                    <?php
                }
                ?>
                <form autocomplete="off" action="<?php echo base_url(); ?>User/Register" method="post" class="form-horizontal">
                    <div id="regFormHolder" class="well well-blue col-lg-12">
                        <fieldset>
                            <center><legend>Registro</legend></center>
                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label" style="text-align: left">Email </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Email" name="email" id="email"/>
                                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nick" class="col-lg-2 control-label" style="text-align: left">Nickname </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Nickname" name="nick" id="nick"/>
                                    <?php echo form_error('nick', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-lg-2 control-label" style="text-align: left">Password </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="password" placeholder="Password" name="password" id="password"/>
                                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="passwordConf" class="col-lg-2 control-label" style="text-align: left">Confirmar password </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="password" placeholder="Confirmar password" name="passwordConf" id="passwordConf"/>
                                    <?php echo form_error('passwordConf', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label" style="text-align: left">Name </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Name" name="name" id="name"/>
                                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-lg-2 control-label" style="text-align: left">LastName </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Last Name" name="lastname" id="lastname"/>
                                    <?php echo form_error('lastname', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthday" class="col-lg-2 control-label" style="text-align: left">Birthday </label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="dd/mm/YYY" name="birthday" id="birthday"/>
                                    <?php echo form_error('birthday', '<div class="error">', '</div>'); ?>

                                </div>

                            </div>
                            <!-- calendario -->
                            <!-- ACA UN JS QUE NOS DEJE ELEGIR LA FECHA-->
                            <div class="form-group">
                                <label for="gender" class="col-lg-2 control-label" style="text-align: left">Gender </label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="0">Masculine</option>
                                        <option value="1">Female</option>
                                    </select>
                                    <?php echo form_error('gender', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary " value="Enter" name="whocares">Submit</button>
                                </div>
                            </div>

                        </fieldset>

                    </div>
                </form>

            </div>

            <?php $this->load->view('footer'); ?>
    </body>
</html>