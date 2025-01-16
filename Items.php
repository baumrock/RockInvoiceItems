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

  /**
   * Get an array of VAT rates and their totals
   * @return array Array of VAT rates and their totals, e.g. ['7.5' => 123, '10' => 1230]
   */
  public function getVatArray(): array
  {
    $vatArray = [];
    foreach ($this->data as $item) {
      $vatRate = $item->vat();
      if (!$vatRate) continue;
      $vatValue = ($item->total() * $vatRate) / 100;
      $vatArray[(string)$vatRate] = ($vatArray[(string)$vatRate] ?? 0) + $vatValue;
    }

    // Format numbers and remove zero values
    foreach ($vatArray as $key => $value) {
      $vatArray[$key] = number_format($value, 2, '.', '');
      if ($vatArray[$key] === "0.00") unset($vatArray[$key]);
    }

    return $vatArray;
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
}
