<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>


<section class="card">
	<div class="row spacer">
<!--------------- Card Image ------------------->
		<div class="small-12 medium-12 large-12 columns image">
			<div class="views-field views-field-field-image"><?php print $fields['field_image']->content; ?></div>
		</div>
<!--------------- Love, views & Created ------------------->

		<div class="small-3 medium-3 large-3 columns views">			
		<img src="/sites/all/themes/knowhowapp/images/App_Icons/views.svg" class="icon-viewed_card">
			<div class="views-field views-field-counter">
	
			<?php print $fields['totalcount']->content; ?></div>
	  	</div>

			<div class="small-3 medium-3 large-3 columns love">
				<img src="/sites/all/themes/knowhowapp/images/App_Icons/loved.svg" class="icon-loved_card">
               <div class="field field-name-love left">
			   	
			   <?php print $fields['field_cardlikes']->content; ?></div>
      </div>
			<div class="small-3 medium-3 large-3 columns comments">
				<img src="/sites/all/themes/knowhowapp/images/App_Icons/commented.svg" class="icon-comments_card">
               <div class="field field-name-comments left">	
				
			   <?php print $fields['comment_count']->content; ?></div>
      </div>


		<div class="small-3 medium-3 large-3 columns posted right">

			      <?php
						$ArticleUdate = trim($fields['created']->content);
						$ArticleInt = preg_replace("/[^0-9]/","",$ArticleUdate);
						$ArticleDtU = substr($ArticleInt,-10);

			      $interval = date('U') - (int)$ArticleDtU;
			      $hour = 60*60;
			      $day = 24*$hour;
			      $time_ago = t("");
			      if ($interval < $hour) {
			        $time_ago .= t("moments ago");
			      }
			      elseif ($interval < $day) {
			        $time_ago .= t("today");
			      }
			      elseif ($interval < 2*$day) {
			        $time_ago .= t("yesterday");
			      }
			      else {
			        $time_ago .= format_interval($interval, 1) . t(' ago');
			      }
			?>
			<div class="views-field views-field-created right"><?php print $time_ago ?></div>
	  	</div>
<!--------------- Title & Body content ------------------->
		<div class="small-12 medium-12 large-12 columns title">
			<div class="views-field views-field-title"><?php print $fields['title']->content; ?></div>
	  	</div>

		<div class="small-12 medium-12 large-12 columns body">
			<div class="views-field views-field-body"><?php print $fields['body']->content; ?></div>
	  	</div>
<!--------------- Tags & Created ------------------->

		<div class="small-12 medium-12 large-12 columns tags">

			<div class="views-field views-field-field-tags"><?php print $fields['field_tags']->content; ?></div>
	  	</div>
<!--------------- Admin picture, name and role ------------------->

			<div class="small-7 medium-5 large-5 columns picture">
				<div class="views-field views-field-field-userprofileimg"><?php print $fields['field_userprofileimg']->content; ?></div>
			</div>

			<div class="small-5 medium-7 large-7 columns usernamerole">
				<div class="views-field views-field-field-userfirstname"><span class="firstname"><?php print $fields['field_userfirstname']->content; ?></span>
				<?php print $fields['field_userlastname']->content; ?></div>

				<div class="views-field views-field-field-userjobtitle"><?php print $fields['field_userjobtitle']->content; ?></div>
			</div>

<!--------------- end ------------------->
	</div>
</section>
