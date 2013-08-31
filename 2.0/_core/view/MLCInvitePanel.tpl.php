<?php if(!is_null($_CONTROL->objEntity)){ ?>
    <p>
        Invite some one to the roll of <b><?php echo $_CONTROL->strRollType; ?></b> for <b><?php echo $_CONTROL->objEntity->__toString(); ?></b>
    </p>

    <div class="control-group">
        <label for="puesto" class="control-label">Email</label>
        <div class="controls">
            <div class="input-append">
                <?php $_CONTROL->txtEmail->Render(); ?>
                <?php $_CONTROL->lnkInvite->Render(); ?>
            </div>
        </div>
    </div>
<?php } ?>

