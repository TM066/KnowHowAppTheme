<?php

/**
 * Build a query extender configuration form.
 *
 * @param $form
 *   The form array that the query extender UI should be added to.
 * @param $form_state
 *   The form state corresponding to the the given $form.
 * @param $index
 *   The search index being queried.
 * @param $options
 *   The current query extender configurations.
 * @param $form_parents
 *   The parents of the query extender UI in the form.
 *
 * @return array
 *   The form array given in the $form parameter, with the query extender UI
 *   added.
 *
 * @see search_api_extended_processors_admin_form_validate()
 * @see search_api_extended_processors_admin_form_submit()
 */
function search_api_extended_processors_admin_form(array $form, array &$form_state, SearchApiIndex $index, array $processors, array $form_parents) {

  $form['extended_processors_override'] = array(
    '#type' => 'checkbox',
    '#title' => t('Override base Processors'),
    '#description' => t('Enable this setting to override the processors defined at the Index level, and only execute the Extended Processors below.'),
    '#default_value' => FALSE,
  );

  $processors_info = search_api_extended_processors_get_extended_processors();

  /** @var SearchApiProcessorInterface[] $processors_objects */
  $processors_objects = isset($form_state['extended_processors']) ? $form_state['extended_processors'] : array();
  foreach ($processors_info as $name => $processor) {
    if (!isset($processors[$name])) {
      $processors[$name]['status'] = 0;
      $processors[$name]['weight'] = $processor['weight'];
    }
    $settings = empty($processors[$name]['settings']) ? array() : $processors[$name]['settings'];
    if (empty($processors_objects[$name]) && class_exists($processor['class'])) {
      $processors_objects[$name] = new $processor['class']($index, $settings);
    }
    if (!(class_exists($processor['class'])
      && $processors_objects[$name] instanceof SearchApiProcessorInterface)) {

      watchdog('search_api', t('Processor @id specifies illegal extender class @class.', array(
          '@id' => $name,
          '@class' => $processor['class']))
        , NULL, WATCHDOG_WARNING);
      unset($processors_info[$name]);
      unset($processors[$name]);
      unset($processors_objects[$name]);
      continue;
    }
    if (!$processors_objects[$name]->supportsIndex($index)) {
      unset($processors_info[$name]);
      unset($processors[$name]);
      unset($processors_objects[$name]);
      continue;
    }
  }
  $form_state['extended_processors'] = $processors_objects;
  $form['#extended_processors'] = $processors;
  $form['extended_processors'] = array(
    '#type' => 'fieldset',
    '#title' => t('Extended Processors'),
    '#description' => t('Select processors which will pre- and post-process the query at search time, and their order.'),
    '#collapsible' => TRUE,
    '#collapsed' => !count($processors_info),
    '#tree' => TRUE,
    '#attached' => array(
      'js' => array(
        drupal_get_path('module', 'search_api_extended_processors') . '/search_api_extended_processors.js',
      ),
    ),
  );

  // Processors status.
  $form['extended_processors']['status'] = array(
    '#type' => 'item',
    '#title' => t('Enabled Processors'),
    '#prefix' => '<div class="search-api-extended-processors-status-wrapper">',
    '#suffix' => '</div>',
  );
  foreach ($processors_info as $name => $processor) {
    $form['extended_processors']['status'][$name] = array(
      '#type' => 'checkbox',
      '#title' => $processor['name'],
      '#default_value' => $processors[$name]['status'],
      '#parents' => array_merge($form_parents, array('extended_processors', $name, 'status')),
      '#description' => $processor['description'],
      '#weight' => $processor['weight'],
    );
  }

  // Processors order (tabledrag).
  $form['extended_processors']['order'] = array(
    '#type' => 'item',
    '#title' => t('Processing order'),
    '#description' => t('Set the order in which pre-processing will be done ad search time. ' .
      'Post-processing of search results will be in the exact opposite direction.'),
    '#theme' => 'search_api_admin_item_order',
    '#table_id' => 'search-api-extended-processors-order-table',
  );
  foreach ($processors_info as $name => $processor) {
    $form['extended_processors']['order'][$name]['item'] = array(
      '#markup' => $processor['name'],
    );
    $form['extended_processors']['order'][$name]['weight'] = array(
      '#type' => 'weight',
      '#delta' => 50,
      '#default_value' => $processors[$name]['weight'],
      '#parents' => array_merge($form_parents, array('extended_processors', $name, 'weight')),
    );
    $form['processors']['order'][$name]['#weight'] = $processors[$name]['weight'];
  }

  // Processor settings.
  $form['extended_processors']['settings_title'] = array(
    '#type' => 'item',
    '#title' => t('Processor settings'),
  );
  $form['extended_processors']['settings'] = array(
    '#type' => 'vertical_tabs',
  );

  foreach ($processors_info as $name => $processor) {
    $settings_form = $processors_objects[$name]->configurationForm();
    if (!empty($settings_form)) {
      $form['extended_processors']['settings'][$name] = array(
        '#type' => 'fieldset',
        '#title' => $processor['name'],
        '#parents' => array_merge($form_parents, array('extended_processors', $name, 'settings')),
        '#weight' => $processor['weight'],
      );
      $form['extended_processors']['settings'][$name] += $settings_form;
    }
  }

  return $form;
}

/**
 * Form validator for the query extenders form.
 *
 * @see search_api_extended_processors_admin_form()
 */
function search_api_extended_processors_admin_form_validate(&$form, &$form_state, &$form_values) {
  // Call validation functions.
  /** @var $processor SearchApiProcessorInterface */
  foreach ($form_state['extended_processors'] as $name => $processor) {
    if (isset($form['extended_processors']['settings'][$name])
      && isset($form_values['extended_processors'][$name]['settings'])) {

      $processor->configurationFormValidate(
        $form['extended_processors']['settings'][$name],
        $form_values['extended_processors'][$name]['settings'],
        $form_state
      );
    }
  }
}

/**
 * Form submit function for the query extenders form.
 *
 * @see search_api_extended_processors_admin_form()
 */
function search_api_extended_processors_admin_form_submit(&$form, &$form_state, &$form_values) {
  // Remove extra/dirty form data.
  unset($form_values['extended_processors']['settings']);

  /** @var $extended_processor SearchApiProcessorInterface */
  foreach ($form_state['extended_processors'] as $name => $extended_processor) {
    $extended_processor_form = isset($form['extended_processors']['settings'][$name])
      ? $form['extended_processors']['settings'][$name]
      : array();

    // Avoid processing empty configurations.
    if (!is_array($form_values['extended_processors'][$name])) {
      continue;
    }

    $form_values['extended_processors'][$name] += array('settings' => array());
    $form_values['extended_processors'][$name]['settings'] =
      $extended_processor->configurationFormSubmit(
        $extended_processor_form,
        $form_values['extended_processors'][$name]['settings'],
        $form_state
      );

    // If the Processor is disabled, do not store its settings.
    if (!$form_values['extended_processors'][$name]['status']) {
      unset($form_values['extended_processors'][$name]);
    }
  }

  if (!empty($form_values['extended_processors'])) {
    // Load in the admin include from "Search API", as we need its functions.
    form_load_include($form_state, 'admin.inc', 'search_api');

    // Save the already sorted arrays to avoid having to sort them at each use.
    uasort($form_values['extended_processors'], 'search_api_admin_element_compare');
  }
}
