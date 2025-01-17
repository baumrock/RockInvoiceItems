<?php

namespace ProcessWire;

if (!$items->count()) return;

/**
 * This markup is used in RockInvoice for rendering invoice items in
 * a PDF invoice.You can use it without the RockInvoice module by using
 * RockFrontend's domtools to modify the markup to your needs.
 */

$pos = 1;

?>
<div class='mt3'></div>
<table class='w-full f10'>
  <thead>
    <tr class='bg-muted'>
      <th class='pos p1 w1 text-center'>#</th>
      <th class='text p1 text-left'><?= __('Item') ?></th>
      <th class='net p1 w1 text-right'><?= __('Net') ?></th>
      <th class='vat p1 w1 text-right'><?= __('VAT') ?></th>
      <th class='quantity w1 p1 text-right'><?= __('Quantity') ?></th>
      <th class='total p1 w1 text-right'><?= __('Total') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
      <tr>
        <td class='border-bottom pos p1 text-center'><?= $pos++ ?></td>
        <td class='border-bottom text p1'><?= $item->text ?></td>
        <td class='border-bottom net p1 pl3 text-right'><?= $item->net ?></td>
        <td class='border-bottom vat p1 pl3 text-right'><?= $item->vat ?>%</td>
        <td class='border-bottom quantity pl3 p1 text-center'><?= $item->quantity ?></td>
        <td class='border-bottom total p1 pl3 text-right'><?= $item->totalNet ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
<table class='w-full'>
  <tr>
    <td class='text-right pr3 v-bottom'>
      <!-- <table>
        <tr>
          <td class='bg-muted p3'>
            <table>
              <tr>
                <td>
                  Zahlungsmethode: <strong>SEPA-Lastschrift</strong>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table> -->
    </td>
    <td class='w1 pl3'>
      <table class='f10'>
        <tr>
          <td class='nowrap p1 text-right w1'><?= __('Subtotal (excl. VAT)') ?>:</td>
          <td class='nowrap p1 pl3 text-right'><?= $items->subtotal() ?></td>
        </tr>
        <?php foreach ($items->vatArray() as $rate => $total): ?>
          <tr>
            <td class='nowrap px1 text-right w1'><?= $rate ?>% <?= __('VAT') ?>:</td>
            <td class='nowrap px1 pl3 text-right'><?= $total ?></td>
          </tr>
        <?php endforeach ?>
        <tr>
          <td class='nowrap p1 text-right w1 text-bold f12'><?= __('Total (incl. VAT)') ?>:</td>
          <td class='nowrap p1 pl3 text-right text-bold f12'><?= $items->grandtotal() ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div class='mt10'></div>