<!--------------- Admin picture, name and role ------------------->
		<div class="small-4 medium-4 large-4 columns picture">
			<div class="views-field views-field-field-userprofileimg">
			<?php print $fields['field_userprofileimg']->content; ?>
			
			</div>
	  	</div>

		<div class="small-8 medium-8 large-8 columns usernamerole">
			<div class="views-field views-field-field-userfirstname"><span class="firstname">
			<?php print $fields['field_userfirstname']->content; ?></span>
			<?php print $fields['field_userlastname']->content; ?></div>

			<div class="views-field views-field-field-userjobtitle">
			<?php print $fields['field_userjobtitle']->content; ?>
			</div>
	  	</div>

<!--------------- end ------------------->
