<?php

namespace ProcessWire;

$info = [
  'title' => 'RockInvoiceItems',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'Invoiceitems Inputfield',
  'icon' => 'list-ol',
  'requires' => [
    'RockInvoice',
  ],
];
