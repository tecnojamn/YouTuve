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

    <body style="    padding-top: 70px;">
        <style>

        </style>
        <?php if ($this->session->flashdata('message') && $this->session->flashdata('error') === 1) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('message') ?> </div>
        <?php } else if ($this->session->flashdata('message') && $this->session->flashdata('error') === 0) { ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('message') ?> </div>
        <?php } ?> 

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" rel="home" href="#">Admin Panel</a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Videos</a></li>
                    <li><a href="#">Comentarios</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="col-sm-3 col-md-3 pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url(); ?>admin/adminsession/signout">Salir</a></li> 
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="bs-example" data-example-id="condensed-table">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Nick</th>
                            <th>Estado</th>
                            <th>Baneado hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($users)) {
                            foreach ($users as $user) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $user->id ?></th>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->name; ?></td>
                                    <td><?php echo $user->lastname; ?></td>
                                    <td><?php echo $user->nick; ?></td>
                                    <td><?php echo $user->active == 1 ? "<b style='color:#00FF00'>Activo</b>" : "<b style='color:#FF0000'>Inactivo</b>"; ?></td>
                                    <td><?php if(!($user->banned_until == '0000-00-00')) {
                                        echo date("d/m/Y", strtotime($user->banned_until)); ?> 
                                        <a title="Eliminar ban" href="<?php echo base_url().'admin/adminusers/unban/'.$user->id;?>">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                   <?php  } ?>  
                                    </td>

                                    <td>
                                        <a title="Dar de <?php echo $user->active==1?'baja':'alta'; ?>" href="<?php echo base_url().'admin/adminusers/'. ($user->active==1?'delete':'undelete').'/'.$user->id;?>">
                                            <span class="glyphicon <?php echo $user->active==1?"glyphicon-remove":"glyphicon-ok" ?>" aria-hidden="true"></span>
                                        </a>
                                        <a title="Agregar un mes de ban" href="<?php echo base_url().'admin/adminusers/ban/'.$user->id;?>">
                                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>