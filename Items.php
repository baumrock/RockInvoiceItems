<?php

namespace RockInvoiceItems;

use ProcessWire\WireArray;

class Items extends WireArray
{
  public function __construct($str = null)
  {
    $this->importJSON($str);
  }

  public function __debugInfo()
  {
    return [
      'items' => $this->data,
    ];
  }

  private function importItems($items = null): void
  {
    if (!is_array($items)) return;
    foreach ($items as $item) {
      $this->add(new Item($item));
    }
  }

  public function importJSON($json): void
  {
    if (!$json) return;
    $data = json_decode($json, true);
    $this->importItems(@$data['items']);
  }

  public function toJSON(): string
  {
    $arr = [];
    $arr['items'] = [];
    foreach ($this as $item) {
      $arr['items'][] = $item->getJsonArray();
    }
    return json_encode($arr);
  }

  /**
   * This method is called when the textarea is populated with data
   * @return string
   */
  public function __toString(): string
  {
    return $this->toJSON();
  }
}
