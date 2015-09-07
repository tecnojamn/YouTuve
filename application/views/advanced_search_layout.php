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
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body>

        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>
        <style>
            .advs-title{    text-align: center;
                            font-size: 25px;
                            line-height: 25px;
                            margin: 0;
                            color: #FFFFFF;
                            background-color: #158CBA;
                            padding: 5px;}
            .advs-container{height: auto;overflow: hidden;background-color: #F8F8F8;border-bottom: 3px solid #FF6060;}
            .advs-container ul{    list-style: none;
                                   padding:0;
                                   margin-bottom: 0;}
            .advs-container ul li{       padding: 5px;
                                         background-color: rgba(55, 199, 255, 0.06);
                                         text-align: center;
                                         margin: 5px 0px;
                                         border-radius: 5px;
                                         cursor: pointer;}
            .advs-container ul li:hover,.advs-container ul li.advs-filter-selected{    background-color: #158CBA;
                                                                                       color: #EAF5F9;
                                                                                       box-shadow: 0px 3px 0px #127BA3;}
            .advs-filters-colum{padding: 15px 25px;}
            .advs-main-title{    font-size: 20px;
                                 padding-left: 25px;
                                 line-height: 37px;
                                 background-color: #158CBA;
                                 color: white;}
            </style>
            <div class="row" style="padding: 0 15px;">

            <div class="advs-container" style="">
                <div class="advs-main-title">Busqueda avanzada</div>
                <div style="    padding-top: 15px;padding-left: 25px;padding-right: 25px;">
                    <input id="advs-query" style="padding: 5px;font-size: 15px; width: 100%;" type="text" placeholder="Buscar" value=""/></div>
                <div class="advs-filters-colum col-lg-3">
                    <p class="advs-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></p>
                    <ul>
                        <li class="advs-filter" data-filter-name="today">Hoy</li>
                        <li class="advs-filter" data-filter-name="this_week">Esta semana</li>
                        <li class="advs-filter" data-filter-name="this_month">Este mes</li>
                        <li class="advs-filter" data-filter-name="this_year">Este año</li>
                    </ul>
                </div>
                <div class="advs-filters-colum col-lg-3">
                    <p class="advs-title"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></p>
                    <ul>
                        <li class="advs-filter" data-filter-name="movie">Pelicula</li>
                        <li class="advs-filter" data-filter-name="serie">Serie</li>
                        <li class="advs-filter" data-filter-name="other">Otro</li>
                    </ul>
                </div>
                <div class="advs-filters-colum col-lg-3">
                    <p class="advs-title"><span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span></p>
                    <ul >
                        <li class="advs-filter" data-filter-name="most_viewed">Más vistos</li>
                        <li class="advs-filter" data-filter-name="most_rated">Más Rankeados</li>
                    </ul>
                </div>
            </div>

            <div class="row" style="min-height: 800px;">
                <div class="col-lg-12" style=";padding:0 15px;" id="videos">

                    <div class="row" style="min-height: 800px;">
                        <?php if ($searched_videos) { ?>
                            <div class = "col-lg-12 well" style = "overflow: hidden;
                                 background-color: transparent;
                                 border: none;
                                 min-height: 800px;">


                                <?php
                                foreach ($searched_videos->list as $video) {
                                    ?>

                                    <div class = "col-lg-12 well well-red" style = "overflow: hidden;">
                                        <div class = "col-lg-3">
                                            <a href = "<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                                                <img src = "http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style = "width:100%">
                                            </a></div>
                                        <div class = "col-lg-9"><label ><?php echo $video->name
                                    ?></label> <br>
                                            <a href="<?php echo base_url(); ?>channel/view/<?php echo $video->idChannel ?>"> <?php echo $video->channelName ?> </a> <br>
                                            <label >Publicado el <?php echo $video->date ?></label> <br>
                                            <label ><?php echo $video->views ?> Visualizaciones</label></div>
                                    </div>
                                    <?php
                                }
                                ?></div><?php
                        } else {
                            ?>
                            <?php if ($searching == 1) { ?>
                                <div class = "col-lg-12 well" style = "overflow: hidden;
                                     background-color: transparent;
                                     border: none;
                                     min-height: 800px;">
                                    <div class = "col-lg-12 well well-yellow" style = "overflow: hidden;">
                                        La busqueda concluyo sin videos



                                    </div>
                                </div>
                            <?php } ?>

                        <?php } ?>

                        <div></div></div>


                    <?php $this->load->view('footer'); ?>
                    </body>
                    </html>