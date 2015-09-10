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
                            <th>Name</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                            <tbody>
                    <?php
                    if ($videos !== NULL && count($videos->list) > 0) {
                        foreach ($videos->list as $video) {
                            ?>
                            <th scope="row"><?php echo $video->id ?></th>
                            <td><?php echo $video->name ?></td>
                            <td><?php
                                if ($video->active == 1) {
                                    echo "Active";
                                } else {
                                    echo "Inactive";
                                }
                                ?>
                            </td>
                            <tr>
                                <td>
                                    <a title="dar baja" href="url-admin-borrar/ID OBJETO PHP">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </a>
                                    <a title="dar alta" href="url-admin-levantar/ID OBJETO PHP">
                                        <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>
                                    </a>
                                    <a title="ir a" href="url-ir-a/ID OBJETO PHP">
                                        <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                                                    <?php
                        }
                    }
                    ?>
                            </tbody>

                </table>
            </div></div>

    </body>
</html>