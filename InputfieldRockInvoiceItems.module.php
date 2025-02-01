<?php

namespace ProcessWire;

/**
 * @author Bernhard Baumrock, 14.01.2025
 * @license COMMERCIAL DO NOT DISTRIBUTE
 * @link https://www.baumrock.com
 */
class InputfieldRockInvoiceItems extends InputfieldTextarea
{

  private function addAsset(string $asset): void
  {
    $url = wire()->config->urls($this);
    $type = str_ends_with($asset, '.js') ? 'scripts' : 'styles';
    wire()->config->{$type}->add(
      wire()->config->versionUrl($url . $asset)
    );
  }
  /**
   * Render the Inputfield
   * @return string
   */
  public function ___render()
  {
    $textarea = parent::___render();
    $items = wire()->files->render(__DIR__ . '/assets/invoiceitems.php');
    return $textarea . $items;
  }

  public function renderReady(?Inputfield $parent = null, $renderValueMode = false)
  {
    if (wire()->config->rockdevtools) {
      rockdevtools()->assets()->minify(__DIR__ . '/src', __DIR__ . '/dst');
    }
    $this->addAsset('dst/RockInvoiceItems.min.js');
    $this->addAsset('dst/RockInvoiceItems.min.css');
  }
}
