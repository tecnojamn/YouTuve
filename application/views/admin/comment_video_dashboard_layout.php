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
        <?php $this->load->view('admin/header_dashboard_layout'); ?>

        <div class="container-fluid">
            <div class="bs-example" data-example-id="condensed-table">
                <table class="table table-responsive table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del video</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($videos) && isset($videos->list)) {
                            foreach ($videos->list as $video) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $video->id ?></th>
                                    <td><?php echo $video->name; ?></td>
                                    <td>
                                        <a title="Ver comments" href="<?php echo base_url();?>admin/admincomments/viewCommentsFromVideo/<?php echo $video->id?>">
                                            <p>Ver comentarios</p>
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