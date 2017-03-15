<?php

/**
 * Trait TraitSearchApiExtendedProcessorViewsQuery
 *
 * This Trait contains shared code for Extended Processor query, form, init and
 * common setup functions. Since the Extended Processor functionality must be
 * provided as a separated module, we HAVE TO deal with other modules extending
 * or overriding the standard SearchApiViewsQuery class (ie. SearchAPI ET)
 *
 */
trait TraitSearchApiExtendedProcessorViewsQuery {

  /**
   * Create the basic query object and fill with default values.
   *
   * The default query (SearchApiQuery) will be replaced by our query object
   * (SearchApiExtendedProcessorQuery) that integrates query-time Processors.
   *
   * @todo Identify how to not override a SearchApiQuery that has been already
   *   overwritten before.
   *
   */
  public function init($base_table, $base_field, $options) {
    parent::init($base_table, $base_field, $options);

    // Override the query only if we're dealing with a SearchApiIndex and a SearchApiQuery
    if (($this->getIndex() instanceof SearchApiIndex) && ($this->getSearchApiQuery() instanceof SearchApiQuery)) {
      $originalQuery = $this->getSearchApiQuery();
      $this->query = new SearchApiExtendedProcessorQuery(
        $originalQuery->getIndex(),
        $originalQuery->getOptions()
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function option_definition() {
    return parent::option_definition() + array(
      'extended_processors' => array(
        'default' => array(),
      ),
      'extended_processors_override' => array(
        'default' => FALSE,
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(&$view) {
    if (!empty($this->errors)) {
      return;
    }
    parent::build($view);

    // Set Index-level processors override option.
    $this->query->setOption('extended_processors_override', $this->options['extended_processors_override']);

    // Add any query extenders requested.
    if (!empty($this->options['extended_processors'])) {
      $this->query->setOption('extended_processors', $this->options['extended_processors']);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    // Load in the admin include from "Search API Extended Processors", as we need its form builder.
    form_load_include($form_state, 'admin.inc', 'search_api_extended_processors');
    $form += search_api_extended_processors_admin_form($form, $form_state, $this->index, $this->options['extended_processors'], array('query', 'options'));
  }

  /**
   * @param $form
   * @param $form_state
   */
  public function options_validate(&$form, &$form_state) {
    search_api_extended_processors_admin_form_validate($form['options'], $form_state, $form_state['values']['query']['options']);
    parent::options_validate($form, $form_state);
  }

  /**
   * @param $form
   * @param $form_state
   */
  public function options_submit(&$form, &$form_state) {
    search_api_extended_processors_admin_form_submit($form['options'], $form_state, $form_state['values']['query']['options']);
    parent::options_submit($form, $form_state);
  }
}
