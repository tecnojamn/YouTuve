<?php if (isset($type) && isset($messageText)) { ?>
    <div style="width:100%;height:auto;position: fixed; top:0px;" id="messageBox">
        <?php if ($type == "error") {
            ?>
            <div class="alert alert-dismissible alert-danger" id="messageBox">
                <?php
            } else if ($type == "warning") {
                ?>
                <div class="alert alert-dismissible alert-warning" id="messageBox">
                    <?php
                } else if ($type == "message") {
                    ?>
                    <div class="alert alert-dismissible alert-success" id="messageBox">
                        <?php
                    }
                    ?>
                    <label> <?php echo $messageText ?> </label>
                </div>
            </div>
            <?php
        }