
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <!-- estilo formulario -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
        <link href="../../calendario/css/calendario.css" rel="stylesheet" type="text/css"/>
        <script src="../../calendario/js/calendario.js" type="text/javascript"></script>
        <script src="../../calendario/js/jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
		$(function(){
			$("#birthday").datepicker({
				changeMonth:true,
				changeYear:true,
				showOn: "button",
				buttonImage: "../../calendario/css/images/ico.png",
				buttonImageOnly: true,
				showButtonPanel: true,
			})
		})
	</script>
    </head>

    <body>
        <?php (isset($log) && $log) ? $this->load->view('header') : $this->load->view('header_default'); ?>

        <form action="<?php echo base_url(); ?>User/Register" method="post" class="form-horizontal">
            <div class="container" style="height: 500px; width: 33%;">
                <fieldset>
                    <center><legend>Registro</legend></center>
                    <div class="form-group">
                        <label for="email" class="col-lg-2 control-label" style="text-align: left">Email</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="Email" name="email" id="email"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nick" class="col-lg-2 control-label" style="text-align: left">Nickname</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="Nickname" name="nick" id="nick"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-lg-2 control-label" style="text-align: left">Password</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="password" placeholder="Password" name="password" id="password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label" style="text-align: left">Name</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="Name" name="name" id="name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-lg-2 control-label" style="text-align: left">LastName</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="Last Name" name="lastname" id="lastname"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday" class="col-lg-2 control-label" style="text-align: left">Birthday</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="dd/mm/YYY" name="birthday" id="birthday"/>

                        </div>
                        
                    </div>
                    <!-- calendario -->
                    <!-- ACA UN JS QUE NOS DEJE ELEGIR LA FECHA-->
                    <div class="form-group">
                        <label for="gender" class="col-lg-2 control-label" style="text-align: left">Gender</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="gender" name="gender">
                                <option>Masculine</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary " value="Enter" name="whocares">Submit</button>
                        </div>
                    </div>

                </fieldset>
                
            </div>
        </form>


        <?php $this->load->view('footer'); ?>
    </body>
</html>