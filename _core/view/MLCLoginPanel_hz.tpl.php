<style>
    .MLCLoginPanel input{
        width:100Px;
    }
    .MLCLoginPanel .btn{
        width:75Px;
    }
</style>
<div class="navbar-form pull-right">
	<?php $_CONTROL->divAlert->Render(); ?>
    <?php $_CONTROL->txtEmail->Render(); ?>
    <?php $_CONTROL->txtPass->Render(); ?> <?php $_CONTROL->btnSubmit->Render(); ?>
</div>
			
	