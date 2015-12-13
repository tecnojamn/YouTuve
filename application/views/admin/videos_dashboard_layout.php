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

    <script> $(document).ready(function () {
            $("ul.pagination a").wrap("<li></li>");
            $("ul.pagination strong").wrap("<li class='active'><a></a></li>");
        });
    </script>
    <body style="    padding-top: 70px;">
        <style>

        </style>

        <?php $this->load->view('admin/header_dashboard_layout'); ?>

        <div class="container-fluid">
            <div class="bs-example" data-example-id="condensed-table">
                <table class="table table-responsive  table-striped table-condensed">
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
                        $cont = 0;
                        if ($videos !== NULL && count($videos->list) > 0) {
                            foreach ($videos->list as $video) {
                                ?>
                                <tr id="<?php echo $cont; ?>">

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
                                    <td>
                                        <?php if ($video->active == 1) {
                                            ?>
                                            <a title="dar baja" href="<?php echo base_url(); ?>admin/adminvideos/deactivate/<?php echo $video->id ?>">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        <?php }
                                        ?>
                                        <?php if ($video->active == 0) {
                                            ?>
                                            <a title="dar alta" href="<?php echo base_url(); ?>admin/adminvideos/activate/<?php echo $video->id ?>">
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                        <a target="blank" title="ir a" href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                                            <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
                                        </a>
                                        <a title="vistas por mes" href="<?php echo base_url(); ?>admin/adminvideos/viewschart/<?php echo $video->id ?>">
                                            <span class=" glyphicon glyphicon-equalizer" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $cont++;
                            }
                        }
                        ?>
                    </tbody>

                </table>
            </div>

        </div>
        <div style="text-align: center;">
            <ul class="pagination">
                <?php echo $links; ?>
            </ul>
        </div>

    </body>
</html>