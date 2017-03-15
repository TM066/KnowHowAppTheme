<div id="wrapperBackbround">
    <div class="containerPanel">
		<div id="auth_box" class="login">
			

			  <div id="middle_part">
			  	<h1 id="the_logo">
					
					<img src="/sites/all/themes/<?php print $GLOBALS['theme']; ?>/images/connect_logo.svg" alt="<?php print $site_name; ?>">
				
				</h1>
				

				<?php print $messages; ?>
				
				<?php print render($page['content']); ?>
			
				<div class="password_link">
				  <?php print l(t('Forgot your password?'), 'user/password'); ?>
				</div>

				<?php if (variable_get('user_register')): ?>
				<div class="register_link">
				  <?php print l(t('Register a new account'), 'user/register'); ?>
				</div>
				<?php endif; ?>

				<div class="back_link">
				  <a href="<?php print url('<front>'); ?>">&larr; <?php print t('Back'); ?> <?php print $site_name; ?></a>
				</div>
			  </div>
		</div>

	</div>
</div>
