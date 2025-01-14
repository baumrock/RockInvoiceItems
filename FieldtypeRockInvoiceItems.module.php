<?php

namespace ProcessWire;

/**
 * @author Bernhard Baumrock, 14.01.2025
 * @license COMMERCIAL DO NOT DISTRIBUTE
 * @link https://www.baumrock.com
 */
class FieldtypeRockInvoiceItems extends FieldtypeTextarea
{
  public function getInputfield(Page $page, Field $field)
  {
    return wire()->modules->get('InputfieldRockInvoiceItems');
  }
}
