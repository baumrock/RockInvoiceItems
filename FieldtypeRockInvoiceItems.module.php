<?php

namespace ProcessWire;

use RockInvoiceItems\Items;

/**
 * @author Bernhard Baumrock, 14.01.2025
 * @license MIT as of 2026-01-21
 * @link https://www.baumrock.com
 */
require_once __DIR__ . '/Item.php';
require_once __DIR__ . '/Items.php';
class FieldtypeRockInvoiceItems extends FieldtypeTextarea
{

  /**
   * Formatted value is the raw JSON string at the moment
   * Maybe change this in the future to a basic table?
   * @param mixed $page
   * @param mixed $field
   * @param mixed $value
   * @return string
   */
  public function formatValue($page, $field, $value)
  {
    return (string)$value;
  }

  /**
   * Returns an empty Items object
   * @param Page|NullPage $page
   * @param Field $field
   * @return string|int|object|null
   */
  public function getBlankValue(Page $page, Field $field)
  {
    return new Items();
  }

  /**
   * Links the inputfield to this fieldtype
   * @param Page $page
   * @param Field $field
   * @return Inputfield
   * @throws WireException
   * @throws WirePermissionException
   */
  public function getInputfield(Page $page, Field $field)
  {
    return wire()->modules->get('InputfieldRockInvoiceItems');
  }

  /**
   * Called when a page is saved (and in some other cases)
   *
   * This is important to make sure that getUnformatted is always an Items
   * object and not a raw json string!
   *
   * See https://processwire.com/talk/topic/7416-understanding-fieldtypetextarealanguagewakeupvalue/?do=findComment&comment=71711
   *
   * @param Page $page
   * @param Field $field
   * @param string $value
   * @return string
   */
  public function sanitizeValue(Page $page, Field $field, $value)
  {
    if (!$value instanceof Items) $value = new Items($value);
    return $value;
  }

  /**
   * Returns an items object when value is loaded from the DB
   * @param mixed $page
   * @param mixed $field
   * @param mixed $value
   * @return Items
   */
  public function wakeupValue($page, $field, $value)
  {
    return new Items($value);
  }
}
