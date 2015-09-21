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
        <script type="text/javascript">
            $(document).ready(function () {
                $("ul.pagination a").wrap("<li></li>");
                $("ul.pagination strong").wrap("<li class='active'><a></a></li>");


            });
        </script>
        <?php if ($this->session->flashdata('message') && $this->session->flashdata('error') === 1) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('message') ?> </div>
        <?php } else if ($this->session->flashdata('message') && $this->session->flashdata('error') === 0) { ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('message') ?> </div>
        <?php } ?> 

        <?php $this->load->view('admin/header_dashboard_layout'); ?>
            
        <div class="container-fluid">
            <div class="bs-example" data-example-id="condensed-table">
                <table class="table table-responsive table-striped table-condensed">
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
                                    <td><?php if (!($user->banned_until == '0000-00-00')) {
                            echo date("d/m/Y", strtotime($user->banned_until));
                                    ?> 
                                            <a title="Eliminar ban" href="<?php echo base_url() . 'admin/adminusers/unban/' . $user->id; ?>">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
        <?php } ?>  
                                    </td>

                                    <td>
                                        <a title="Dar de <?php echo $user->active == 1 ? 'baja' : 'alta'; ?>" href="<?php echo base_url() . 'admin/adminusers/' . ($user->active == 1 ? 'delete' : 'undelete') . '/' . $user->id; ?>">
                                            <span class="glyphicon <?php echo $user->active == 1 ? "glyphicon-remove" : "glyphicon-ok" ?>" aria-hidden="true"></span>
                                        </a>
                                        <a title="Agregar un mes de ban" href="<?php echo base_url() . 'admin/adminusers/ban/' . $user->id; ?>">
                                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                                        </a>
                                        <a title="Resetear Contraseña" href="<?php echo base_url() . 'admin/adminusers/resetPassword/' . $user->id; ?>">
                                            <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>
                <div style="text-align: center;">
                    <ul class="pagination">
                        <?php echo $pagerLinks; ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>