
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Subir Video</title>
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
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <?php
                if (isset($error) && $error && isset($error_message) && $error_message !== "") {
                    ?>
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>
                <form action="<?php echo base_url(); ?>video/doUpload" method="post" class="form-horizontal">
                    <div class="well col-lg-12">
                        <fieldset>
                            <center><legend>Subir video</legend></center>
                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label" style="text-align: left">Nombre:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Nombre" name="name" id="email"/>
                                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="link" class="col-lg-2 control-label" style="text-align: left">Link Id</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Link Id" name="link" id="nick"/>
                                    <?php echo form_error('link', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="duration" class="col-lg-2 control-label" style="text-align: left">Duración</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Duración (en segundos)" name="duration" id="name"/>
                                    <?php echo form_error('duration', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary " value="Subir" name="whocares">Subir</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="col-lg-4"></div>
        </div>

        <?php $this->load->view('footer'); ?>
    </body>
</html>