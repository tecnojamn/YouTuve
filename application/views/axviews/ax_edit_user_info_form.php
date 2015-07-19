<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<script>
    $(function () {
        $("#birthday").datepicker({
            dateFormat: "dd/mm/yyyy",
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>/css/calendar/css/images/ico.png",
            buttonImageOnly: true,
            showButtonPanel: true,
        })
    });
</script>
<form action="<?php echo base_url(); ?>User/editInfo" method="post" class="form-horizontal">
    <fieldset>                  
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label" style="text-align: left">Name</label>
            <div class="col-lg-10">
                <input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo $name?>" id="name"/>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-lg-2 control-label" style="text-align: left">LastName</label>
            <div class="col-lg-10">
                <input class="form-control" type="text" placeholder="Last Name" name="lastname" value="<?php echo $lastname?>" id="lastname"/>
            </div>
        </div>
        <div class="form-group">
            <label for="birthday" class="col-lg-2 control-label" style="text-align: left">Birthday</label>
            <div class="col-lg-10">
                <input class="form-control" type="text" placeholder="dd/mm/YYYY" name="birthday" value="<?php echo date('d/m/Y', strtotime($birthday)) ?>" id="birthday"/>
            </div>
        </div>
        <div class="form-group">
            <label for="gender" class="col-lg-2 control-label" style="text-align: left">Gender</label>
            <div class="col-lg-10">
                <select class="form-control" id="gender"  name="gender">
                    <option value="0">Hombre</option>
                    <option <?php echo $gender==1?"selected":""; ?> value="1">Mujer</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary " value="Enter" name="whocares">Submit</button>
            </div>
        </div>

    </fieldset></form>