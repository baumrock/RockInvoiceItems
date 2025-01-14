<?php

namespace ProcessWire;

?>
<div class='uk-overflow-auto'>
  <table class='uk-table uk-table-small uk-table-striped rockinvoice-items-table uk-margin-remove'>
    <thead>
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
    <tbody>
      <?php for ($i = 0; $i < 10; $i++): ?>
        <tr>
          <td><span class="sort-handle" uk-icon="icon: table"></span></td>
          <td class='uk-width-expand text'>
            Sed magna purus fermentum euSed magna
          </td>
          <td class='net'>
            <input type='number' class='uk-input'>
          </td>
          <td class='vat'>
            <div class='uk-flex uk-flex-middle'>
              <input type='number' class='uk-input'>
              <span>%</span>
            </div>
          </td>
          <td class='quantity'>
            <input type='number' class='uk-input'>
          </td>
          <td class='total'>
            <strong class='uk-input'>€ 1.000.000,00</strong>
          </td>
          <td class='delete'>
            <a href>
              <i class='fa fa-trash-o' aria-hidden='true'></i>
            </a>
          </td>
        </tr>
      <?php endfor; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan='6' class='uk-text-right'>
          <table class='uk-inline totals uk-margin-remove'>
            <tr>
              <td><?= __('Subtotal (Excl. VAT)') ?></td>
              <td>XXX</td>
            </tr>
            <tr>
              <td>10% <?= __('VAT') ?></td>
              <td>XXX</td>
            </tr>
            <tr>
              <td>20% <?= __('VAT') ?></td>
              <td>XXX</td>
            </tr>
            <tr class='uk-text-bold uk-text-lead'>
              <td><?= __('Total (Incl. VAT)') ?></td>
              <td>XXX</td>
            </tr>
          </table>
        </td>
        <td></td>
      </tr>
    </tfoot>
  </table>
  <script>
    (() => {
      const wrapper = document.currentScript.parentNode;
      $(document).ready(function() {
        const tbody = wrapper.querySelector('tbody');
        $(tbody).sortable({
          handle: '.sort-handle',
          cursor: 'grabbing',
        });
      });
    })()
  </script>
</div>