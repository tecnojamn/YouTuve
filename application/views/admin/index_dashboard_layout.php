<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin_css.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body style="    padding-top: 70px;">
        <style>

        </style>
        <?php $this->load->view('admin/header_dashboard_layout'); ?>

        <div class="container-fluid">
            <div class="col-md-12">
                <p>Dashboard</p>
            </div>
            <div class="row col-md-10 col-md-offset-1">
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['users']['active']; ?></div>
                                    <div>Usuarios activos</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url(); ?>admin/adminusers">
                            <div class="panel-footer">
                                <span class="pull-left">ver usuarios</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['users']['inactive']; ?></div>
                                    <div>Usuarios inactivos</div>
                                </div>
                            </div>
                        </div>
                         <a href="<?php echo base_url(); ?>admin/adminusers">
                            <div class="panel-footer">
                                <span class="pull-left">Ver usuarios</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['users']['total']; ?></div>
                                    <div>Usuarios totales</div>
                                </div>
                            </div>
                        </div>
                         <a href="<?php echo base_url(); ?>admin/adminusers">
                            <div class="panel-footer">
                                <span class="pull-left">Ver usuarios</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>



                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-hd-video" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['videos']['active']; ?></div>
                                    <div>Videos activos</div>
                                </div>
                            </div>
                        </div>
                         <a href="<?php echo base_url(); ?>admin/adminvideos">
                            <div class="panel-footer">
                                <span class="pull-left">Ver videos</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-hd-video" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['videos']['inactive']; ?></div>
                                    <div>Videos inactivos</div>
                                </div>
                            </div>
                        </div>
                         <a href="<?php echo base_url(); ?>admin/adminvideos">
                            <div class="panel-footer">
                                <span class="pull-left">Ver videos</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-hd-video" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['videos']['total']; ?></div>
                                    <div>Videos totales</div>
                                </div>
                            </div>
                        </div>
                         <a href="<?php echo base_url(); ?>admin/adminvideos">
                            <div class="panel-footer">
                                <span class="pull-left">Ver videos</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['comments']['active']; ?></div>
                                    <div>Comentarios activos</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['comments']['inactive']; ?></div>
                                    <div>Comentarios inactivos</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totals['comments']['total']; ?></div>
                                    <div>Comentarios totales</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>
    </body>
</html>