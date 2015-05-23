<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<div id="errorThumbForm" style="display:none" class="alert alert-dismissible alert-danger">
    <P id="msg"></P>
</div>
<form id="uploadimage" action="<?php echo base_url(); ?>User/uploadThumb"  enctype="multipart/form-data"  method="post" class="form-horizontal">
    <fieldset>                  
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label" style="text-align: left">Imagen</label>
            <div class="col-lg-10">
                <input class="form-control" type="file" placeholder="Name" name="user_thumb" id="name"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <input type="submit" class="btn btn-primary " value="Cambiar" name="whocares"/>
            </div>
        </div>
    </fieldset>
</form>