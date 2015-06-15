<?php ?>
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
                    <button type="button" class="navbar-toggle collapse" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo $this->session->userdata('nick'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Mi canal</a></li>
                                <li><a href="<?php echo base_url(); ?>ViewHistory/showHistory">Ver historial</a></li>
                                <li><a href="<?php echo base_url(); ?>user/profile/me">Ver Perfil</a></li>
                                <li><a href="<?php echo base_url(); ?>video/upload">Subir Video</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url(); ?>User/logOut">Salir</a></li>
                    </ul>


                </div> 
            </nav>
        </div>



    </div>