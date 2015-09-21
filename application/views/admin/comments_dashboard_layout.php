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
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Comentario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($comments) && isset($comments->list)) {
                            foreach ($comments->list as $comment) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $comment->id ?></th>
                                    <td><?php echo $comment->usernick; ?></td>
                                    <td><?php echo $comment->date; ?></td>
                                    <td><?php echo $comment->comment; ?></td>
                                    <td><?php echo $comment->active == 1 ? "<b style='color:#00FF00'>Activo</b>" : "<b style='color:#FF0000'>Inactivo</b>"; ?></td>
                                    <td>
                                        <a title="Dar de <?php echo $comment->active == 1 ? 'baja' : 'alta'; ?>" href="<?php echo base_url() . 'admin/admincomments/' . ($comment->active == 1 ? 'delete' : 'undelete') . '/' . $comment->id; ?>">
                                            <span class="glyphicon <?php echo $comment->active == 1 ? "glyphicon-remove" : "glyphicon-ok" ?>" aria-hidden="true"></span>
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