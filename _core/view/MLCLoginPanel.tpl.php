<div class="row">
    <div class="span4">
    	<h5>
			<?php $_CONTROL->divAlert->Render(); ?>
		</h5>
	</div>
	<div class="span4">
		Email: <?php $_CONTROL->txtEmail->Render(); ?>
	</div>
	<div class="span4">
		Pass: &nbsp;<?php $_CONTROL->txtPass->Render(); ?>
	</div>
	<div class="span4">
		<div class="btn-group">
			<?php $_CONTROL->btnSubmit->Render(); ?>
		</div>
	</div>
	<!--div class="span4">
		<?php $_CONTROL->btnForgotPass->Render(); ?>
	</div>
	<div class="span4">
		<?php $_CONTROL->pnlForgotPass->Render(); ?>
	</div-->
</div>