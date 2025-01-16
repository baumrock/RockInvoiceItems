<?php

namespace ProcessWire;

use RockInvoiceItems\Items;

/**
 * @author Bernhard Baumrock, 14.01.2025
 * @license COMMERCIAL DO NOT DISTRIBUTE
 * @link https://www.baumrock.com
 */
require_once __DIR__ . '/Item.php';
require_once __DIR__ . '/Items.php';
class FieldtypeRockInvoiceItems extends FieldtypeTextarea
{

  public function formatValue($page, $field, $value)
  {
    if (!$value instanceof Items) return;
    return wire()->files->render(__DIR__ . '/assets/invoiceitems-pdf.php', [
      'items' => $value
    ]);
  }

  public function getBlankValue(Page $page, Field $field)
  {
    return new Items();
  }

  public function getInputfield(Page $page, Field $field)
  {
    return wire()->modules->get('InputfieldRockInvoiceItems');
  }

  public function wakeupValue($page, $field, $value)
  {
    return new Items($value);
  }
}
