<?php

/**
 * @file
 * Contains the entity_views_handler_field_text class.
 */

/**
 * A handler to display text data.
 *
 * Overrides the default Views handler to retrieve the data from an entity via
 * data selection.
 *
 * This handler may only be used in conjunction with data selection based Views
 * tables or other base tables using a query plugin that supports data
 * selection.
 *
 * @see entity_views_field_definition()
 * @ingroup views_field_handlers
 */
class search_api_view_modes_handler_field_text extends entity_views_handler_field_text {

  /**
   * Render a single field value.
   *
   * Since we know this is our rendered view mode markup stored in the search backend,
   * it is okay to return it with decode_entities so HTML is not escaped.
   */
  public function render_single_value($value, $values) {
    return decode_entities($value);
  }

}
