<?php

namespace ProcessWire;

/**
 * GUI for InputfieldRockInvoiceItems
 */
?>
<div class='uk-overflow-auto'>
  <table class='uk-table uk-table-small uk-table-striped rockinvoice-items-table uk-margin-remove'>
    <thead class='labels' hidden>
      <tr>
        <th></th>
        <th class='uk-width-expand'><?= __('Item') ?></th>
        <th class='uk-text-center'><?= __('NET') ?></th>
        <th class='uk-text-center'><?= __('VAT') ?></th>
        <th class='uk-text-center'><?= __('Quantity') ?></th>
        <th class='uk-text-center'><?= __('Total') ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody class='items'>
      <template>
        <tr class='uk-animation-fade'>
          <td class='uk-text-nowrap icons'>
            <a
              href
              class="sort-handle"
              title='<?= __('Move row') ?>'
              uk-tooltip>
              <i class='fa fa-bars' aria-hidden='true'></i>
            </a>
            <a
              href
              class='clone-row'
              title='<?= __('Clone row') ?>'
              uk-tooltip>
              <i class='fa fa-clone' aria-hidden='true'></i>
            </a>
          </td>
          <td class='uk-width-expand text'>
            <textarea class='uk-textarea' rows=1></textarea>
            <div class='inline-editor uk-textarea'></div>
          </td>
          <td class='net'>
            <input type='number' class='uk-input' step='0.01' value=0>
          </td>
          <td class='vat'>
            <div class='uk-flex uk-flex-middle'>
              <input type='number' class='uk-input' step='0.01' value=0>
              <span>%</span>
            </div>
          </td>
          <td class='quantity'>
            <input type='number' class='uk-input' step='0.01' value=1>
          </td>
          <td class='total'>
            <strong class='uk-input uk-text-right uk-display-block'></strong>
          </td>
          <td class='delete'>
            <a class='delete-row' href>
              <i class='fa fa-trash-o' aria-hidden='true'></i>
            </a>
          </td>
        </tr>
      </template>
    </tbody>
    <tfoot>
      <tr>

        <!-- new row button -->
        <td colspan='2' class='uk-text-nowrap uk-padding-remove-left'>
          <a href class='add-row uk-button uk-button-default uk-button-small'>
            <i class='fa fa-plus' aria-hidden='true'></i>
            <?= __('Add item') ?>
          </a>
        </td>

        <!-- totals table -->
        <td colspan='4' class='uk-width-expand uk-text-right'>
          <table class='uk-inline totals uk-margin-remove' hidden>
            <tr>
              <td><?= __('Subtotal (Excl. VAT)') ?></td>
              <td class='subtotal'></td>
            </tr>
            <tr class='vattotal' hidden>
              <td><span class='rate'></span> <?= __('VAT') ?></td>
              <td class='value'></td>
            </tr>
            <tr class='uk-text-bold'>
              <td><?= __('Total (Incl. VAT)') ?></td>
              <td class='grandtotal'></td>
            </tr>
          </table>
        </td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
<script>
  RockInvoiceItems.init();
</script>