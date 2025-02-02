# RockInvoiceItems

A ProcessWire module that provides a powerful and flexible invoice item management interface for creating and managing invoice line items.

<img src=invoiceitems.gif class=blur>

## Features

- Dynamic line item management with add, delete, and clone functionality
- Rich text editing support via TinyMCE integration
- Automatic calculation of subtotals, VAT, and grand totals
- Support for multiple VAT rates
- Sortable invoice items via drag and drop
- Real-time calculation updates
- Clean and intuitive user interface
- Automatic data persistence
- Responsive design that works well on all screen sizes (using overflow scroll)
- Fully translatable (German Translations included via RockLanguage)

## Installation

1. Download the module
2. Copy it to your site/modules/ directory
3. Install the module in ProcessWire admin

## Usage

The module provides a Fieldtype/Inputfield combo that can be added to any ProcessWire template.

Each line item supports:

- Description (with rich text editing)
- Net amount
- VAT rate
- Quantity
- Automatic total calculation

## RockInvoiceItems\Items

The `RockInvoiceItems\Items` class extends `WireArray` and provides functionality for managing a collection of invoice items. It handles JSON serialization/deserialization and provides methods for calculating totals and VAT.

### Methods

- `grandtotal()`: Calculates the total amount including VAT
- `subtotal()`: Calculates the total amount excluding VAT
- `vattotal()`: Calculates the total VAT amount
- `vatArray()`: Returns an array of VAT rates and their totals (e.g. ['7.5' => 123, '10' => 1230])

