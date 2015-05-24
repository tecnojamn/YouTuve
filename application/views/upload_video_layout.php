
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Subir Video</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootswatch.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <!-- estilo formulario -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
    </head>

    <body>
        <script>
            var tags =<?php echo $tags ?>;
            var lastTagSearchVal = "";
            var tagsAdded = 0;
            console.log(tags);
            $(document).ready(function () {
                $("#videUploadForm").submit(function (e) {
                    //e.preventDefault();
                    $("#tagBox").children('.littleTag').each(function () {
                        $("#videUploadForm").append("<input type='hidden' name='tags[]' value='" + $(this).attr("data-id") + "'/>")
                    });
                });
                $(document).on("click", ".littleTag span", function () {
                    $(this).parent(".littleTag").remove();
                    tagsAdded--;
                    $("#tagForm").show();
                });
                $(document).on("click", ".videoTag", function () {
                    $("#tagBox").append("<div data-id='" + $(this).attr("data-id") + "' class='littleTag'>" + $(this).text() + "<span>×</span></div>");
                    resetTagResults();
                    $("#tagTexter").val("");
                    tagsAdded++;
                    if (tagsAdded === 3) {
                        $("#tagForm").hide();
                    }
                });
                $("#tagTexter").keyup(function (e) {
                    if (e.which === 46 || e.wich === 8) {

                        return;
                    }
                    resetTagResults();
                    var val = $.trim(this.value);
                    var totalRes = 0;
                    if (val !== lastTagSearchVal && val.length > 0) {
                        lastTagSearchVal = val;
                        jQuery.each(tags.list, function (i, Obj) {
                            if (Obj.name.toLowerCase().indexOf(val.toLocaleLowerCase()) >= 0) {
                                totalRes++;
                                addToTagResults(Obj.id, Obj.name);
                            }
                        });
                        if (totalRes > 0) {
                            $("#tagResults").show();
                        }
                    }
                });

                function addToTagResults(id, name) {
                    $("#tagResults").append("<p class='videoTag' data-id='" + id + "'>" + name + "</p>");
                }
                function resetTagResults() {
                    $("#tagResults").empty().hide();
                    var lastTagSearchVal = "";
                }
            });

        </script>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <?php
                if (isset($error) && $error && isset($error_message) && $error_message !== "") {
                    ?>
                    <div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>
                <form id="videUploadForm" autocomplete="off" action="<?php echo base_url(); ?>video/doUpload" method="post" class="form-horizontal">
                    <div class="well col-lg-12">
                        <fieldset>
                            <center><legend>Subir video</legend></center>
                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label" style="text-align: left">Nombre:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Nombre" name="name" id="email"/>
                                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="link" class="col-lg-2 control-label" style="text-align: left">Link Id</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Link Id" name="link" id="nick"/>
                                    <?php echo form_error('link', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="duration" class="col-lg-2 control-label" style="text-align: left">Duración</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" placeholder="Duración (en segundos)" name="duration" id="name"/>
                                    <?php echo form_error('duration', '<div class="error">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group" id="tagForm">
                                <label  for="duration" class="col-lg-2 control-label" style="text-align: left">Tags</label> 

                                <div class="col-lg-10">
                                    <input id="tagTexter" class="form-control" type="text" placeholder="Busque tag" name="x" id="name"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10" style=""id="tagResults">

                                </div></div>
                            <div class="form-group"><label  for="duration" class="col-lg-2 control-label" style="text-align: left"></label> 
                                <div class="col-lg-10">
                                    <div id="tagBox" >

                                    </div></div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary " value="Subir" name="whocares">Subir</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="col-lg-4"></div>
        </div>

        <?php $this->load->view('footer'); ?>
    </body>
</html>