<?php

namespace RockInvoiceItems;

use ProcessWire\WireArray;
use RockMoney\Money;

use function ProcessWire\rockmoney;

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

  /**
   * This method is called when the textarea is populated with data
   * @return string
   */
  public function __toString(): string
  {
    return $this->toJSON();
  }

  /**
   * Calculate the grand total including VAT
   * @return float
   */
  public function grandtotal(): Money
  {
    $total = rockmoney(0);
    foreach ($this as $item) {
      $total = $total->plus($item->totalGross);
    }
    return $total;
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

  /**
   * Calculate the subtotal excluding VAT
   * @return float
   */
  public function subtotal(): Money
  {
    $total = rockmoney(0);
    foreach ($this as $item) {
      $total = $total->plus($item->totalNet);
    }
    return $total;
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
   * Get an array of VAT rates and their totals
   * @return array Array of VAT rates and their totals, e.g. ['7.5' => 123, '10' => 1230]
   */
  public function vatArray(): array
  {
    $vatArray = [];
    foreach ($this->data as $item) {
      /** @var Item $item */
      if (!$item->vat) continue;
      $key = (string)$item->vat;
      if (!isset($vatArray[$key])) {
        $vatArray[$key] = rockmoney(0);
      }
      $vatArray[$key] = $vatArray[$key]->plus($item->totalNet->times($item->vatRate()));
    }
    ksort($vatArray);
    return $vatArray;
  }

  public function vattotal(): Money
  {
    $total = rockmoney(0);
    foreach ($this as $item) {
      $total = $total->plus($item->totalVat);
    }
    return $total;
  }
}
