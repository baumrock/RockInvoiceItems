<?php

namespace ProcessWire;

$pos = 1;
?>
<div class='mt3'></div>
<table class='w-full f10 mb5'>
  <thead>
    <tr class='bg-muted'>
      <th class='pos p1 w1 text-center'>#</th>
      <th class='text p1 text-left'><?= __('Description') ?></th>
      <th class='net p1 w1 text-right'><?= __('Net') ?></th>
      <th class='vat p1 w1 text-right'><?= __('VAT') ?></th>
      <th class='quantity w1 p1 text-right'><?= __('Quantity') ?></th>
      <th class='total p1 w1 text-right'><?= __('Total') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($value as $item): ?>
      <tr>
        <td class='border-top pos p1 text-center'><?= $pos++ ?></td>
        <td class='border-top text p1'><?= $item->text ?></td>
        <td class='border-top net p1 pl3 text-right'><?= $item->net ?></td>
        <td class='border-top vat p1 pl3 text-right'><?= $item->vat ?>%</td>
        <td class='border-top quantity pl3 p1 text-center'><?= $item->quantity ?></td>
        <td class='border-top total p1 pl3 text-right'><?= $item->totalNet ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>