<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<div class="container">
    <div class="col-lg-12">
        <div class="page-header"style="
             height: 70px;
             border: none;
             padding-bottom: 20px;
             margin: 0;
             ">
            <nav class="navbar navbar-default">


                <div class="navbar-header">                    
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">YouTuve</a>
                </div>

                <div class="navbar-collapse  collapse" id="bs-example-navbar-collapse-1" aria-expanded="true">
                    <div class="col-md-6">
                        <form autocomplete="off" class="navbar-form navbar-left" role="search" action="<?php echo base_url(); ?>video/search" method="GET">
                            <div class="form-group">
                                <input type="text" name="query" class="form-control" placeholder="">
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo base_url(); ?>User/loginForm">Login</a></li>
                        <li><a href="<?php echo base_url(); ?>User/registerForm">Registro</a></li>
                    </ul>


                </div>

            </nav>

        </div>

    </div>