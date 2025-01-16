<?php

namespace RockInvoiceItems;

use HTMLPurifier_Exception;
use ProcessWire\WireData;
use ProcessWire\WireException;
use ProcessWire\WirePermissionException;
use RockMoney\Money;

use function ProcessWire\rockmoney;
use function ProcessWire\wire;

class Item extends WireData
{
  public string $text;
  public Money $net;
  public Money $vat;
  public float $quantity;
  public Money $totalNet;
  public Money $totalGross;

  public function __construct(array $data = [])
  {
    $this->text = '';
    $this->net = rockmoney()->parse(0);
    $this->vat = rockmoney()->parse(0);
    $this->quantity = 0;
    $this->importArray($data);
  }

  public function __debugInfo()
  {
    return [
      'text' => $this->text,
      'net' => $this->net,
      'vat' => $this->vat,
      'quantity' => $this->quantity,
      'totalNet' => $this->totalNet,
      'totalGross' => $this->totalGross,
    ];
  }

  public function float($data): float
  {
    return round((float) $data, 2);
  }

  /**
   * Get array ready for json encodeing
   * @return array
   */
  public function getJsonArray(): array
  {
    return [
      'text' => (string)$this->text,
      'net' => $this->net->getFloat(),
      'vat' => $this->vat->getFloat(),
      'quantity' => (float)$this->quantity,
    ];
  }

  /**
   * Import plain array data
   */
  private function importArray(array $data): void
  {
    foreach ($data as $key => $value) {
      if ($key === 'text') $this->text = wire()->sanitizer->purify($value);
      if ($key === 'net') $this->net = rockmoney($value);
      if ($key === 'vat') $this->vat = rockmoney($value);
      if ($key === 'quantity') $this->quantity = $this->float($value);
    }
    $this->setTotals();
  }

  public function setTotals(): void
  {
    $this->totalNet = $this->net->times($this->quantity);
    $this->totalGross = $this->net->times($this->quantity)->times(1 + $this->vatRate());
  }

  public function toJSON(): string
  {
    return json_encode($this->getJsonArray());
  }

  public function __toString()
  {
    return $this->toJSON();
  }

  public function vatRate(): float
  {
    return $this->vat->getFloat() / 100;
  }
}
