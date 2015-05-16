
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
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <form action="<?php echo base_url(); ?>User/Register" method="post">

            <input type="text" placeholder="email" name="email"/>

            <input type="text" placeholder="nick" name="nick"/>
            <input type="password" placeholder="password" name="password"/>
            <input type="text" placeholder="name" name="name"/>
            <input type="text" placeholder="lastname" name="lastname"/>
            <!-- ACA UN JS QUE NOS DEJE ELEGIR LA FECHA-->
            <input type="text" placeholder="birthday" name="birthday"/>
            <input type="text" placeholder="gender" name="gender"/>

            <input type="submit" value="Enter" name="whocares"/>
        </form>


        <?php $this->load->view('footer'); ?>
    </body>
</html>