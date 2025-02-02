<?php

namespace ProcessWire;

$info = [
  'title' => 'InputfieldRockInvoiceItems',
  'version' => json_decode(file_get_contents(__DIR__ . "/package.json"))->version,
  'summary' => 'Invoice items Inputfield',
  'icon' => 'list-ol',
  'requires' => [
    'FieldtypeRockInvoiceItems',
  ],
];
