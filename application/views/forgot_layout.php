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
                }
                ?>
                <form autocomplete="off" action="<?php echo base_url(); ?>User/mailForgotPassword" method="post" class="form-horizontal">
                    <div class="well col-lg-12">
                        <fieldset>
                            <center><legend>Olvido de contraseña</legend></center>
                            <div class="form-group">
                                <label for="oldPassword" class="col-lg-2 control-label" style="text-align: left">Contraseña</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="email" placeholder="email" name="email" id="oldPassword"/>
                                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
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