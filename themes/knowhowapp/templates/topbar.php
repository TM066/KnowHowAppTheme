		 <!--------------------------------------.top-bar---------------------------------------------- -->

	  <div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <nav class="tab-bar">
      <section class="left-small">
         <!--<a class="left-off-canvas-toggle menu-icon" ><span></span></a>-->
      </section>

      <section class="middle tab-bar-section navIcons">
        <?php
          global $user;
          ?>
			<ul class="inline-list left">
				<li class="navIcon home show-for-large-up"><a href="/" title="Home">	<img src="/sites/all/themes/knowhowapp/images/App_Icons/home.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/home_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/home.svg'" />
					</a>
				</li>

				<li class="navIcon collect show-for-large-up"><a href="/user/<?php print $user->uid ?>/collections" title="My Bookmarks"><img src="/sites/all/themes/knowhowapp/images/App_Icons/collect.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/collect_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/collect.svg'" />
						</a>
				</li>

				<li class="navIcon team show-for-large-up"><a href="/node/53" title="Team"><img src="/sites/all/themes/knowhowapp/images/App_Icons/people.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/people_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/people.svg'" />
					</a>
				</li>

				<li class="navIcon account hide-for-large-up"><a href="<?php print url('user'); ?>" title="My Profile"><img src="/sites/all/themes/knowhowapp/images/App_Icons/profile.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile.svg'" />
					</a>
				</li>
		   </ul>

		 <div class="logo-wrapper">
            <div class="logo">
				<img src="/sites/all/themes/<?php print $GLOBALS['theme']; ?>/images/connect_logo.svg" alt="<?php print $site_name; ?>" title="<?php print $site_name; ?>">

            </div>
          </div>

			<ul class="inline-list right">
				<li class="navIcon account show-for-large-up"><a href="<?php print url('user'); ?>" title="My Profile"><img src="/sites/all/themes/knowhowapp/images/App_Icons/profile.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/profile.svg'" />
					</a>
				</li>

				<li class="navIcon create"><a  href="/node/add/card" title="Create Card"><img src="/sites/all/themes/knowhowapp/images/App_Icons/create.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/create_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/create.svg'" />
						</a>
					</li>

				<li class="navIcon logout show-for-large-up">

					<a href="/?q=user/logout" title="Log out">
						<img src="/sites/all/themes/knowhowapp/images/App_Icons/loginout.svg" onmouseover="this.src='/sites/all/themes/knowhowapp/images/App_Icons/loginout_hover.svg'" onmouseout="this.src='/sites/all/themes/knowhowapp/images/App_Icons/loginout.svg'" />
					</a>
				</li>

		    </ul>



      </section>

      <section class="right-small">
       <!--<a class="right-off-canvas-toggle menu-icon" ><span></span></a>-->
      </section>
    </nav>

    <aside class="left-off-canvas-menu">

<div class="row">
  <div class="large-12 columns">
    <form>
      <div class="row collapse">
        <div class="large-9 columns">
          <input type="search" placeholder="search">
        </div>
        <div class="large-3 columns">
          <span class="postfix">Search</span>
        </div>
      </div>

    </form>
  </div>
</div>

    </aside>

    <aside class="right-off-canvas-menu">
<form class="profile">
  <div class="row">
    <div class="large-12 columns">
<h2> Edit Profile</h2>
   </div>
</div>


  <div class="row">
    <div class="large-12 columns">

</div>

    <div class="login_link">
      <?php print l(t('Login'), 'user/login'); ?>
    </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Name
        <input type="text" placeholder="Name" />
      </label>
    </div>
    <div class="large-12 columns">
      <label>Surname
        <input type="text" placeholder="Surname" />
      </label>
    </div>
</div>


    <div class="row">
    <div class="large-12 columns">
      <label>Select Department
        <select>
          <option value="Tester">Tester</option>
          <option value="Tester2">Tester2</option>
          <option value="Tester3">Tester3</option>
          <option value="Tester4">Tester4</option>
        </select>
      </label>
    </div>
  </div>


    <div class="row">
    <div class="large-12 columns">
      <label>Select Team
        <select>
          <option value="Tester">Tester</option>
          <option value="Tester2">Tester2</option>
          <option value="Tester3">Tester3</option>
          <option value="Tester4">Tester4</option>
        </select>
      </label>
    </div>
  </div>
     <div class="row">
    <div class="large-12 columns">
  <a href="#" class="button tiny round">Save Profile</a>
     </div>
  </div>
</form>
    </aside>

    <section class="main-section">
