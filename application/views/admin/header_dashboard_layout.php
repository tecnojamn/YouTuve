

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
            <li><a href="<?php echo base_url().'admin/adminusers' ?>">Usuarios</a></li>
            <li><a href="<?php echo base_url().'admin/adminvideos' ?>">Videos</a></li>
            <li><a href="<?php echo base_url().'admin/admincomments' ?>">Comentarios</a></li>
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