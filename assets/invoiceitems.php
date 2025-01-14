<?php

namespace ProcessWire;

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
        <tr>
          <td><span class="sort-handle" uk-icon="icon: table"></span></td>
          <td class='uk-width-expand text'>
            TBD
          </td>
          <td class='net'>
            <input type='number' class='uk-input' value=0>
          </td>
          <td class='vat'>
            <div class='uk-flex uk-flex-middle'>
              <input type='number' class='uk-input' value=0>
              <span>%</span>
            </div>
          </td>
          <td class='quantity'>
            <input type='number' class='uk-input' value=1>
          </td>
          <td class='total'>
            <strong class='uk-input'></strong>
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
        <td colspan='2' class='uk-text-nowrap'>
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