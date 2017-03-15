<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<div class="row article headerFix">
<div class="small-12 medium-12 large-12 columns">
   <ul class="inline-list createIcons">

		<li class="artIcon right editCard"><?php if (node_access('update',$node)){print l(theme_image(array('path' => '/sites/all/themes/knowhowapp/images/App_Icons/profile_edit.svg', 'attributes' => array('title' => t('Edit')))), 'node/' . $node->nid . '/edit/' . $cid, array('query' => drupal_get_destination(), 'html' => TRUE));}?></li>
    <li class="artIcon right lovecard"><?php print flag_create_link('likes', $node->nid); ?></li>
		<li class="artIcon right"><a  href="#comments"><img src="/sites/all/themes/knowhowapp/images/App_Icons/comment.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/comment_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/comment.svg'"
				 alt="comment" class="comments"/></a></li>
        <!---<li class="artIcon right"><a  href="#"><img src="/sites/all/themes/knowhowapp/images/App_Icons/share.svg" alt="share" /></a></li>------>
        <li class="artIcon right"><?php print flag_create_link('bookmarks', $node->nid); ?></li>
		 <li class="artIcon left"><a href="/" class="back"><img src="/sites/all/themes/knowhowapp/images/App_Icons/back.svg" alt="back" onclick="history.go(-1)"/></a></li>

   </ul>
</div>

   <!--------------- Card Image ------------------->
   <div class="small-12 medium-12 large-12 columns">
      <div class="panel contents">
         <?php if (!empty($content)): ?>
         <div class="small-12 medium-12 large-12 columns fullImage"<?php print $content_attributes ?>>

            <div class="small-12 medium-12 large-12 columns ArticleImage">
               <div class="field field-name-image_1"><?php print render($content['field_image']) ?></div>
            </div>
			<!--------------- Love, views & Created ------------------->

		<div class="small-3 medium-3 large-3 columns views">
				<img src="/sites/all/themes/knowhowapp/images/App_Icons/views.svg" class="icon-viewed">
			<?php  $stats = statistics_get($nid);
			$total_count = $stats['totalcount'];?>
  			<div class="views-field views-field-counter">
		
			<?php print $total_count; ?></div>
  	  	</div>

        <div class="small-3 medium-3 large-3 columns love">
							<img src="/sites/all/themes/knowhowapp/images/App_Icons/loved.svg" class="icon-loved">
			<div class="field field-name-love left">

				 <?php $flag = flag_get_flag('likes');print $flag->get_count($nid);?>
			</div>
        </div>
			<div class="small-3 medium-3 large-3 columns comments">
					<img src="/sites/all/themes/knowhowapp/images/App_Icons/commented.svg" class="icon-comments">
                <div class="field field-name-comments left">
			
				<?php print $comment_count ?></div>
			</div>
			  
		  
		<div class="small-3 medium-3 large-3 columns posted right">

      <?php
      $interval = date('U') - $node->created;
      $hour = 60*60;
      $day = 24*$hour;
      $week = 7*$day;
      $time_ago = "";
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
<div class="views-field views-field-created right"><?php print $time_ago; ?></div>
	  	</div>

			<!--------------- Title & Body content ------------------->
            <div class="small-12 medium-12 large-12 columns title">
               <div class="field field-name-title"><?php print $title; ?></div>
            </div>
            <div class="small-12 medium-12 large-12 columns body">
               <div class="field field-name-body"><?php print render($content['body']) ?></div>
            </div>

              <?php if ($content['field_cardurl']): ?>
            <!--------------- URL / Attatchment  ------------------->

			<div class="small-12 medium-12 large-12 columns cardURL">
       <h3>Related Link:</h3>
               <div class="field field-name-cardurl"><?php print render($content['field_cardurl']); ?></div>
            </div>
      <?php endif; ?>

         <!--------------- Tags & Created ------------------->
         <div class="small-12 medium-12 large-12 columns tags">
           			<div class="views-field views-field-field-tags"><?php print render($content['field_tags']); ?></div>
         </div>

   <!--------------- Author Information ------------------->
          <div class="small-12 medium-12 large-12 columns">
			   <div class="views-field views-field-field-userprofileimg picture">
					<div class="small-6 medium-5 large-3 columns">
					  <?php $node_author = user_load($node->uid);?>
							<?php $profilefilenm= file_create_url($node_author->field_userprofileimg['und'][0]['uri']); ?>
								<a href="../user/<?php print ($node->uid)?>">
                  <?php if (strrpos($profilefilenm,"sites")): ?>
									<img src="<?php print ($profilefilenm);?>" />
                  <?php else: ?>

                         <img src="/sites/default/files/styles/medium/public/default_images/profile-placeholder_0.png"/>
                      <?php endif; ?>
								</a>
					</div>
				</div>

			 <div class="small-6 medium-7 large-9 columns">
				<div class="small-12 medium-12 large-12 columns authorInfo">
					<?php print ($node_author->field_userfirstname['und'][0]['value']);?>
					<?php print ($node_author->field_userlastname['und'][0]['value']);?>
				</div>
				<div class="small-12 medium-12 large-12 columns authorInfo2">

					<strong><?php  print render (taxonomy_term_load($node_author->field_userjobtitle['und'][0]['tid'])->name);?></strong>
				</div>
		     </div>
		</div>


			<div class="small-12 medium-12 large-12 columns collect">
				<?php if (!empty($post_object)) print render($post_object) ?><?php endif; ?>
				<a name="comments"></a>
			</div>
		     </div>
		 <!--------------- end ------------------->
		 	<p>&nbsp;</p>
      </div>
   </div>
</div>
