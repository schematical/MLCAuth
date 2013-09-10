<form action="/" id="" class="form-horizontal">
    <fieldset>
        <legend>Account Info:</legend>
        <div class="control-group pull-left">
            <label class="control-label" for="email">Email</label>
            <div class="controls">

              <?php $_CONTROL->txtEmail->Render(); ?>
            </div>
        </div>
        <div class="control-group pull-left">
            <label class="control-label" for="pass">Password:</label>
            <div class="controls">
              <?php $_CONTROL->txtPassword1->Render(); ?>
            </div>
        </div>
        <div class="control-group pull-left">
            <label class="control-label" for="pass">
                    Retype Password:
            </label>
            <div class="controls">
                <?php $_CONTROL->txtPassword2->Render(); ?>
            </div>
        </div>
        <div style='clear:both;'></div>
        <div class="form-actions">
            <?php $_CONTROL->lnkSignup->Render(); ?>
        </div>

    </fieldset>
</form>
