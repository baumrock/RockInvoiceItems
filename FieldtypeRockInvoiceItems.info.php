<?php

namespace ProcessWire;

$info = [
  'title' => 'FieldtypeRockInvoiceItems',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'Invoice items Fieldtype',
  'icon' => 'list-ol',
  // RockMoney for money formatting and calculations
  'requires' => [
    'RockMoney',
  ],
  'installs' => [
    'InputfieldRockInvoiceItems',
  ],
];
