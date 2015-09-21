

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" rel="home" href="<?php echo base_url() . 'admin/' ?>">Admin Panel</a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url() . 'admin/adminusers' ?>">Usuarios</a></li>
            <li><a href="<?php echo base_url() . 'admin/adminvideos' ?>">Videos</a></li>
            <li><a href="<?php echo base_url() . 'admin/admincomments' ?>">Comentarios</a></li>
        </ul>
        <div class="col-sm-3 col-md-3 pull-right">
            <ul class="nav navbar-nav">
                <li><p style="margin: 0;
                       padding: 15px;"><?php echo (isset($adminname)) ? $adminname : ''; ?></p></li>
                <li><a href="<?php echo base_url(); ?>admin/adminsession/signout">Salir</a></li> 
            </ul>
        </div>
    </div>
</nav>