<?php
/*top values for percentages on user points*/
$TopCards = 150;
$TopRetorts = 150;
$TopFollowers= 150;
$TopFollowing = 150;

/*current user's values for user points*/
$UserCards = userpoints_get_current_points($uid=$user_id,$tid=2);
$UserRetorts = userpoints_get_current_points($uid=$user_id,$tid=3);
$UserFollowers= userpoints_get_current_points($uid=$user_id,$tid=4);
$UserFollowing = userpoints_get_current_points($uid=$user_id,$tid=5);

/*works out height - how much of the 50px should be darker green*/
$CardGreen=($UserCards/$TopCards)*50;
$RetortGreen=($UserRetorts/$TopRetorts)*50;
$FollowerGreen=($UserFollowers/$TopFollowers)*50;
$FollowingGreen=($UserFollowing/$TopFollowing)*50;
/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
?>
<div class="row bio">

<?php
    $ViewedUID =$user_id;
   $LoggedInUID =$user->uid; ?>

   <div class="small-12 medium-12 large-12 columns">
      <ul class="inline-list createIcons">



		<?php if ($ViewedUID==$LoggedInUID): ?>
			<li class="artIcon profileEdit right"><a href="<?php print url('user/'.$user->uid.'/edit'); ?>">
				<img src="/sites/all/themes/knowhowapp/images/App_Icons/profile_edit.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile_edit_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile_edit.svg'" />
				</a>
			</li>
		<?php endif; ?>


			<li class="artIcon right"><?php print flag_create_link('follow',$uid ); ?></li>

			<li class="artIcon left back"><a href="<?php print url('<front>'); ?>">
				<img src="/sites/all/themes/knowhowapp/images/App_Icons/back.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/back_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/back.svg'" class="back" onclick="history.go(-1)"/>
				</a>
			</li>
      </ul>
   </div>
   <div class="small-12 medium-12 large-12 columns pointsBlock">

      <div class="panel bio contents">
         <div class="small-12 medium-12 large-12 columns BioImage">
            <?php print render($user_profile['field_userbanner']); ?>
         </div>
         <div class="small-12 medium-12 large-12 columns text-center bioInfo">
            <div class="oval"><?php print render($user_profile['field_userprofileimg']); ?>
			</div>

            <div class="nameFields"><span class="vocalizer" data-source="auto"><?php print render($user_profile['field_userfirstname']); ?></span>&nbsp;&nbsp;
            <span><?php print render($user_profile['field_userlastname']); ?></span>
			</div>

            <div class="jobRole"><?php print render($user_profile['field_userjobtitle']); ?></div>

            <div class="jobDept"><?php print render($user_profile['field_userteam']); ?> </div>
         </div>

	<div class="small-12 medium-12 large-12 columns pointsBlocks">
		 <div class="points">
			<div class="pointsDiv">
			<div class="pointsBk">
					<div class="pointsTotal"><?php print $UserCards; ?></div>
				<div class="pointsScore" style="height:<?php print $CardGreen; ?>px"></div>
			</div>
			<div class="pointDesc"><a href="/user/<?php print $user_id ?>/cardcount" >Cards</div>
			</div>

			<div class="pointsDiv">
			<div class="pointsBk">
			<div class="pointsTotal"><?php print $UserRetorts; ?></div>
				 <div class="pointsScore" style="height:<?php print $RetortGreen; ?>px"></div>
				</div>
				<div class="pointDesc"><a class="not-active" href="/user/<?php print $user_id ?>/retortscount">Comments</a></div>
			</div>

			<div class="pointsDiv">
			<div class="pointsBk">
				<div class="pointsTotal"><?php print $UserFollowers; ?></div>
					<div class="pointsScore" style="height:<?php print $FollowerGreen; ?>px"></div>
			</div>
				<div class="pointDesc"><a href="/user/<?php print $user_id ?>/followerscount">Followers</a></div>
			</div>

			<div class="pointsDiv">
			<div class="pointsBk">
			<div class="pointsTotal"><?php print $UserFollowing; ?></div>
				<div class="pointsScore" style="height:<?php print $FollowingGreen; ?>px"></div>
			</div>
				<div class="pointDesc"><a href="/user/<?php print $user_id ?>/followingcount">Following</a></div>
			</div>
		</div>
	</div>

         <ul class="tabs bio" data-tab>
            <li class="tab-title active"><a href="#panel1">Personal Statement</a></li>
            <li class="tab-title"><a href="#panel2">Tradable Skills </a></li>

         </ul>
         <div class="tabs-content">
            <div class="content active" id="panel1">
               	<?php print render($user_profile['field_userbio']); ?>
            </div>
            <div class="content" id="panel2">
              	<?php print render($user_profile['field_usertradableskills']); ?>
            </div>

         </div>
		<div class="small-12 medium-12 large-12 columns skilltags">
			<?php print render($user_profile['field_userskilltags']); ?>
		  </div>

		<?php $usr = user_load(arg(1));
				$useremail=$usr->mail; ?>

		  <div class="small-12 medium-12 large-12 columns contacts">
		  <ul class="contactsList">

<?php if ($user_profile['field_userlocation']): ?>
			<li><img src="/sites/all/themes/knowhowapp/images/App_Icons/location-45.svg">
				<?php print render($user_profile['field_userlocation']); ?>
			</li>
  <?php endif; ?>

<?php if ($useremail): ?>
			<li><img src="/sites/all/themes/knowhowapp/images/App_Icons/email-48.svg">
				<a href="mailto:<?php print  $useremail ?>">&nbsp;<?php print  $useremail ?></a>
			</li>
  <?php endif; ?>

  <?php if ($user_profile['field_usermobile']): ?>
			<li><img src="/sites/all/themes/knowhowapp/images/App_Icons/mobile-46.svg">
				<?php print render($user_profile['field_usermobile']); ?>
			</li>
  <?php endif; ?>

    <?php if ($user_profile['field_userlyncphone']): ?>
			<li><img src="/sites/all/themes/knowhowapp/images/App_Icons/skype-50.svg">
				<?php print render($user_profile['field_userlyncphone']); ?>
			</li>
  <?php endif; ?>

<?php if ($user_profile['field_userlinkedinurl']): ?>
			<li><img src="/sites/all/themes/knowhowapp/images/App_Icons/linkedin-47.svg">
				<?php print render ($user_profile['field_userlinkedinurl']); ?></a>
			</li>
  <?php endif; ?>
			</ul>
		  </div>


      </div>
   </div>
</div>
<div>
