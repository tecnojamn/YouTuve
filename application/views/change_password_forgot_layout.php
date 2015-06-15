<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
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
    </head>
    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <?php
                if (isset($error) && $error && isset($error_message) && $error_message !== "") {
                    ?>
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                    <?php
                } else if (isset($error) && !$error && isset($error_message) && $error_message !== "") {
                    ?>
                    <div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                    <?php
                }
                ?>
                <form autocomplete="off" action="<?php echo base_url(); ?>User/validateNewPassword" method="post" class="form-horizontal">
                    <div class="well col-lg-12">
                        <fieldset>
                            <center><legend>Cambio de contraseña</legend></center>
                            <input type="hidden" name="forgot_token" value="<?php echo $token ?>"/>
                            <div class="form-group">
                                <label for="password" class="col-lg-2 control-label" style="text-align: left">Nueva Contraseña</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="password" placeholder="Nueva Contraseña" name="password" id="password"/>
                                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="passconf" class="col-lg-2 control-label" style="text-align: left">Confirme Contraseña</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="password" placeholder="Confirmación de nueva contraseña" name="passconf" id="passconf"/>
                                    <?php echo form_error('passconf', '<div class="error">', '</div>'); ?>
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
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>