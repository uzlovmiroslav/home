<?php

namespace Drupal\my_friends_common\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * A handler to provide a field that is completely custom.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("days_to_date_field")
 */
class DaysToDateField extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $this->getEntity($values);
    $date = $node->field_birthday_date->value;

    // Calculate the number of days to birthday date (in future).
    $now = strtotime('today');
    $date_parts = explode('-', $date);
    $current_year = date('Y');
    // Set current year to birthday date.
    $date_parts[0] = $current_year;
    // If birthday was in current year already, use next year.
    if (strtotime(implode('-', $date_parts)) < $now) {
      $date_parts[0]++;
    }

    return round((strtotime(implode('-', $date_parts)) - $now) / (60 * 60 * 24));
  }

}
