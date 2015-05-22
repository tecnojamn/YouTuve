<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<form action="<?php echo base_url(); ?>User/editInfo" method="post" class="form-horizontal">
    <fieldset>                  
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
                <input class="form-control" type="text" placeholder="dd/mm/YYYY" name="birthday" id="birthday"/>
            </div>
        </div>
        <div class="form-group">
            <label for="gender" class="col-lg-2 control-label" style="text-align: left">Gender</label>
            <div class="col-lg-10">
                <select class="form-control" id="gender" name="gender">
                    <option value="0">Hombre</option>
                    <option value="1">Mujer</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary " value="Enter" name="whocares">Submit</button>
            </div>
        </div>

    </fieldset></form>