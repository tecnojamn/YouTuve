<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body style="    padding-top: 40px;
          padding-bottom: 40px;
          background-color: #eee;">
        <style>.form-signin .form-signin-heading, .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            form-signin {
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin input[type="email"] {
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }.form-signin .form-control {
                position: relative;
                height: auto;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                padding: 10px;
                font-size: 16px;
            }
        </style>
        <div class="col-lg-4 col-lg-offset-4">

            <?php if ($this->session->flashdata('message') && $this->session->flashdata('error') === 1) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('message') ?> </div>
            <?php } else if ($this->session->flashdata('message') && $this->session->flashdata('error') === 0) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('message') ?> </div>
            <?php } ?> 

            <form method="POST" autocomplete="false" class="form-signin" action="<?php echo base_url(); ?>admin/adminsession/signinpost">
                <h2 class="form-signin-heading">Admin panel Login</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <?php echo form_error('admin_user'); ?>
                <input name="admin_user" type="text" id="inputEmail" class="form-control" placeholder="Usuario"  autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <?php echo form_error('admin_password'); ?>
                <input name="admin_password" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" >
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

        </div>

    </body>
</html>