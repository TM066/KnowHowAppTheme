<?php
/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function knowhowapp_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

function knowhowapp_alpha_preprocess_node(&$vars) {
      if(isset($vars['field_media'][0]['uri']))
      {
        $uri = $vars['field_media'][0]['uri'];
        $url = file_create_url($uri);
        $page_keywords = array(
                         '#type' => 'html_tag',
                         '#tag' => 'meta',
                         '#attributes' => array(
                          'property' => 'og:image',
                          'content' => $url,
                            )
                      );
       drupal_add_html_head($page_keywords, 'page_keywords');
     }
   }




/**
 * Override or insert variables into the page template for HTML output.
 */
function knowhowapp_process_html(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
}

/**
 * Override or insert variables into the page template.
 */
function knowhowapp_process_page(&$variables) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
  $variables['hide_site_name']   = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;
  if ($variables['hide_site_name']) {
    // If toggle_name is FALSE, the site_name will be empty, so we rebuild it.
    $variables['site_name'] = filter_xss_admin(variable_get('site_name', 'Drupal'));
  }
  if ($variables['hide_site_slogan']) {
    // If toggle_site_slogan is FALSE, the site_slogan will be empty, so we rebuild it.
    $variables['site_slogan'] = filter_xss_admin(variable_get('site_slogan', ''));
  }
  // Since the title and the shortcut link are both block level elements,
  // positioning them next to each other is much simpler with a wrapper div.
  if (!empty($variables['title_suffix']['add_or_remove_shortcut']) && $variables['title']) {
    // Add a wrapper div using the title_prefix and title_suffix render elements.
    $variables['title_prefix']['shortcut_wrapper'] = array(
      '#markup' => '<div class="shortcut-wrapper clearfix">',
      '#weight' => 100,
    );
    $variables['title_suffix']['shortcut_wrapper'] = array(
      '#markup' => '</div>',
      '#weight' => -99,
    );
    // Make sure the shortcut link is the first item in title_suffix.
    $variables['title_suffix']['add_or_remove_shortcut']['#weight'] = -100;
  }
}

function knowhowapp_page_alter($page) {
  $meta_ie_render_engine = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'http-equiv' => 'X-UA-Compatible',
        'content' =>  'IE=edge,chrome=1',
      ),
      '#weight' => '-99999'
    );

		$mobileoptimized = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'MobileOptimized',
			'content' =>  'width'
			)
		);

		$handheldfriendly = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'HandheldFriendly',
			'content' =>  'true'
			)
		);

		$viewport = array(
			'#type' => 'html_tag',
			'#tag' => 'meta',
			'#attributes' => array(
			'name' =>  'viewport',
			'content' =>  'width=device-width, initial-scale=1'
			)
		);

    drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');
		drupal_add_html_head($mobileoptimized, 'MobileOptimized');
		drupal_add_html_head($handheldfriendly, 'HandheldFriendly');
		drupal_add_html_head($viewport, 'viewport');

}

function knowhowapp_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // comment below line to hide current page to breadcrumb
	$breadcrumb[] = drupal_get_title();
    $output .= '<div class="breadcrumb">' . implode('<span class="sep">Â»</span>', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * Add Javascript for responsive mobile menu
 */
if (theme_get_setting('responsive_menu_state')) {

	drupal_add_js(drupal_get_path('theme', 'knowhowapp') .'/js/jquery.mobilemenu.js');

    $responsive_menu_switchwidth = (int) theme_get_setting('responsive_menu_switchwidth','knowhowapp');
    $responsive_menu_topoptiontext = theme_get_setting('responsive_menu_topoptiontext','knowhowapp');
    drupal_add_js(array('knowhowapp' => array('topoptiontext' => $responsive_menu_topoptiontext)), 'setting');

	drupal_add_js('jQuery(document).ready(function($) {

	$("#navigation .content > ul").mobileMenu({
		prependTo: "#navigation",
		combine: false,
        switchWidth: '.$responsive_menu_switchwidth.',
        topOptionText: Drupal.settings.knowhowapp[\'topoptiontext\']
	});

	});',
	array('type' => 'inline', 'scope' => 'header'));

}
//EOF:Javascript


/**
 * Make the selected userId on the viewed profile available on the user-profile template
 */
function knowhowapp_preprocess_user_profile(&$variables) {

  $account = $variables['elements']['#account'];
  //Add the user ID into the user profile as a variable
  $variables['user_id'] = $account->uid;
  // Helpful $user_profile variable for templates.
  foreach (element_children($variables['elements']) as $key) {
    $variables['user_profile'][$key] = $variables['elements'][$key];
  }

  // Preprocess fields.
  field_attach_preprocess('user', $account, $variables['elements'], $variables);
}

function knowhowapp_preprocess_page(&$variables) {
  if ($node = menu_get_object()) {
    $variables['node'] = $node;
  }

}
