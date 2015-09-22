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
        <script src="<?php echo base_url(); ?>js/Chart.min.js"></script> 
    </head>

    <body style="    padding-top: 70px;">
        <style>
            p.title{font-size: 16px;
                    text-align: center;}
            </style>
            <?php $this->load->view('admin/header_dashboard_layout'); ?>

            <div class="container-fluid">
            <div class="col-lg-4">
                <p class="title">Vistas de video en los ultimos 6 meses, mensual</p>
                <canvas id="views_chart" width="400" height="400"></canvas>
                <script>
                    var data =<?php echo $chart ?>;
                    var ctx = $("#views_chart").get(0).getContext("2d");
                    var myNewChart = new Chart(ctx).Bar(data, {responsive: true, scaleBeginAtZero: false});
                </script>
            </div>
        </div>
    </body>
</html>