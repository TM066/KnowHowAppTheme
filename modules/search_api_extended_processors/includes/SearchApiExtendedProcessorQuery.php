<?php

/**
 *
 *
 */
class SearchApiExtendedProcessorQuery extends SearchApiQuery {
  /**
   * All enabled query_extenders for this index.
   *
   * @var array
   */
  protected $extended_processors = NULL;

  /**
   * {@inheritdoc}
   */
  public function __construct(SearchApiIndex $index, array $options = array()) {
    parent::__construct($index, $options);
    $this->options = array_merge($options, array(
      // Override the 'search id' parameter, since our parent set it to
      // "SearchApiQuery": this override is required for search_api_facetapi to
      // work correctly.
      'search id' => __CLASS__,
      // Add the extended_processors settings.
      'extended_processors' => array(),
      'extended_processors_override' => FALSE,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function preExecute() {
    // Make sure to only execute this once per query.
    if (!$this->pre_execute) {
      $this->pre_execute = TRUE;
      // Add filter for languages.
      if (isset($this->options['languages'])) {
        $this->addLanguages($this->options['languages']);
      }

      // Add fulltext fields, unless set
      if ($this->fields === NULL) {
        $this->fields = $this->index->getFulltextFields();
      }

      // If the extended processors do not override the Index ones, run the
      // processors defined at the Index level first.
      if ($this->options['extended_processors_override'] == FALSE) {
        // Preprocess query.
        $this->index->preprocessSearchQuery($this);
      }

      // Pre-process query with active Extended Processors.
      foreach ($this->getExtendedProcessors() as $processor) {
        $processor->preprocessSearchQuery($this);
      }
      // Let modules alter the query.
      drupal_alter('search_api_query', $this);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function postExecute(array &$results) {
    // Post-preprocess query with active Extended Processors.
    foreach ($this->getExtendedProcessors() as $processor) {
      $processor->postprocessSearchResults($results, $this);
    }

    // If the extended processors do not override the Index ones, run also the
    // processors defined at the Index level.
    if ($this->options['extended_processors_override'] == FALSE) {
      // Postprocess results.
      $this->index->postprocessSearchResults($results, $this);
    }

    // Let modules alter the results.
    drupal_alter('search_api_results', $results, $this);
  }

  /**
   * @return SearchApiProcessorInterface[]
   *   All enabled extenders for this query, as SearchApiQueryExtenderInterface
   *   objects.
   */
  public function getExtendedProcessors() {
    if (isset($this->extended_processors)) {
      return $this->extended_processors;
    }

    $this->extended_processors = array();
    if (empty($this->options['extended_processors'])) {
      return $this->extended_processors;
    }
    $processors_settings = $this->options['extended_processors'];
    $processor_info = search_api_extended_processors_get_extended_processors();

    foreach ($processors_settings as $id => $settings) {
      if (empty($settings['status'])) {
        continue;
      }
      if (empty($processor_info[$id]) || !class_exists($processor_info[$id]['class'])) {
        watchdog(
          'search_api', t('Undefined processor @class specified in query',
          array('@class' => $id)), NULL, WATCHDOG_WARNING
        );
        continue;
      }
      $class = $processor_info[$id]['class'];
      $processor = new $class($this->getIndex(), isset($settings['settings']) ? $settings['settings'] : array());
      if (!($processor instanceof SearchApiProcessorInterface)) {
        watchdog(
          'search_api', t('Unknown processor class @class specified for processor @name',
          array('@class' => $class, '@name' => $id)), NULL, WATCHDOG_WARNING
        );
        continue;
      }

      $this->extended_processors[$id] = $processor;
    }
    return $this->extended_processors;
  }

}
