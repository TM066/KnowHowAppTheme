<?php

/**
 * @file
 * Views hook implementations for the Search API Views module.
 */

/**
 * Implements hook_views_data_alter().
 */
function search_api_extended_processors_views_data_alter(&$data) {
  // Overriding standard index ViewsQuery class
  foreach (search_api_index_load_multiple(FALSE) as $index) {
    $key = 'search_api_index_' . $index->machine_name;
    $base = &$data[$key]['table']['base'];
    $base['query class'] = 'search_api_extended_processor_query';

    // Avoid overriding SearchAPI ET SearchApiETViewsQuery: SearchAPI ET overrides
    // the default SearchAPI views query handler, in this case we simply switch
    // to the correct query class that extends SearchApiETViewsQuery.
    if (module_exists('search_api_et')) {
      $base['query class'] = 'search_api_extended_processor_et_query';
    }
  }

}

/**
 * Implements hook_views_plugins().
 */
function search_api_extended_processors_views_plugins() {
  $ret = array(
    'query' => array(
      'search_api_extended_processor_query' => array(
        'title' => t('Search API Query (With extended Processor)'),
        'help' => t('Query will be generated and run using the Search API with extended processors.'),
        'handler' => 'SearchApiExtendedProcessorViewsQuery',
      ),
    ),
  );

  // To avoid overriding SearchAPI ET SearchApiETViewsQuery we define here a
  // specific query, that correctly extends SearchApiETViewsQuery class.
  if (module_exists('search_api_et')) {
    $ret['query']['search_api_extended_processor_et_query'] = array(
      'title' => t('Search API Query (With extended Processor)'),
      'help' => t('Query will be generated and run using the Search API with extended processors.'),
      'handler' => 'SearchApiExtendedProcessorETViewsQuery',
    );
  }

  return $ret;
}
