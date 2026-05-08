<?php

return [

    'weight_balance' => [
        'name'   => 'Weight Balance Uses Logbook',
        'fields' => [
            ['name' => 'sr_no',         'label' => 'Sr. No.',        'type' => 'text',   'required' => true,  'width' => 'sm', 'auto_sr' => true],
            ['name' => 'date',          'label' => 'Date',           'type' => 'date',   'required' => true,  'width' => 'sm'],
            ['name' => 'product_name',  'label' => 'Product Name',   'type' => 'product_select',   'required' => true,  'width' => 'sm'],
            ['name' => 'batch_no',      'label' => 'Batch No',       'type' => 'text',   'required' => true,  'width' => 'sm'],
            ['name' => 'parameter',     'label' => 'Parameter',      'type' => 'text',   'required' => true,  'width' => 'md'],
            ['name' => 'weight',        'label' => 'Weight',         'type' => 'number',   'required' => true,  'width' => 'md'],
            ['name' => 'done_by',       'label' => 'Done By',        'type' => 'text',   'required' => true,  'width' => 'md', 'auto_user' => true],
            ['name' => 'remarks',       'label' => 'Remarks',        'type' => 'text',   'required' => false, 'width' => 'full', 'is_remarks' => true],
        ],
        // Fields filled by manager when approving
        'review_fields' => [
            ['name' => 'checked_by',     'label' => 'Checked By',     'type' => 'text', 'required' => true, 'auto_user' => true], 
        ],
    ],

    'ph_meter' => [
        'name'   => 'PH Meter Register Logbook',
        'fields' => [
            ['name' => 'sr_no',        'label' => 'Sr. No.',      'type' => 'text',   'required' => true,  'width' => 'sm', 'auto_sr' => true],
            ['name' => 'date',         'label' => 'Date',         'type' => 'date',   'required' => true,  'width' => 'sm'],
            ['name' => 'time',         'label' => 'Time',         'type' => 'time',   'required' => true,  'width' => 'sm'],
            ['name' => 'product_name', 'label' => 'Product Name', 'type' => 'product_select',   'required' => true,  'width' => 'md'],
            ['name' => 'batch_no',     'label' => 'Batch No',     'type' => 'text',   'required' => true,  'width' => 'sm'],
            ['name' => 'reading',      'label' => 'Reading',      'type' => 'number', 'required' => true,  'width' => 'sm'],
            ['name' => 'done_by',      'label' => 'Done By',      'type' => 'text',   'required' => true,  'width' => 'md', 'auto_user' => true],
            ['name' => 'remarks',      'label' => 'Remarks',      'type' => 'text',   'required' => false, 'width' => 'full', 'is_remarks' => true],
        ],
        'review_fields' => [
            ['name' => 'checked_by',   'label' => 'Checked By',   'type' => 'text', 'required' => true, 'auto_user' => true],
            ['name' => 'checked_date', 'label' => 'Checked Date', 'type' => 'date', 'required' => true],
        ],
    ],
    'Test' => [
        'name'   => 'Test  Register Logbook',
        'fields' => [
            ['name' => 'sr_no',        'label' => 'Sr. No.',      'type' => 'text',   'required' => true,  'width' => 'sm', 'auto_sr' => true],
            ['name' => 'date',         'label' => 'Date',         'type' => 'date',   'required' => true,  'width' => 'sm'],
            ['name' => 'time',         'label' => 'Time',         'type' => 'time',   'required' => true,  'width' => 'sm'],
            ['name' => 'product_name', 'label' => 'Product Name', 'type' => 'product_select',   'required' => true,  'width' => 'md'],
            ['name' => 'batch_no',     'label' => 'Batch No',     'type' => 'text',   'required' => true,  'width' => 'sm'],
            ['name' => 'reading',      'label' => 'Reading',      'type' => 'number', 'required' => true,  'width' => 'sm'],
            ['name' => 'done_by',      'label' => 'Done By',      'type' => 'text',   'required' => true,  'width' => 'md', 'auto_user' => true],
            ['name' => 'remarks',      'label' => 'Remarks',      'type' => 'text',   'required' => false, 'width' => 'full', 'is_remarks' => true],
        ],
        'review_fields' => [
            ['name' => 'checked_by',   'label' => 'Checked By',   'type' => 'text', 'required' => true, 'auto_user' => true],
            ['name' => 'checked_date', 'label' => 'Checked Date', 'type' => 'date', 'required' => true],
        ],
    ],

    'solid_stock' => [
        'name'   => 'Solid Stock Solution Register Logbook',
        'fields' => [
            ['name' => 'sr_no',         'label' => 'Sr. No.',        'type' => 'text',   'required' => true,  'width' => 'sm', 'auto_sr' => true],
            ['name' => 'received_date', 'label' => 'Received Date',  'type' => 'date',   'required' => true,  'width' => 'sm'],
            ['name' => 'quantity',      'label' => 'Quantity',       'type' => 'text',   'required' => true,  'width' => 'sm'],
            ['name' => 'kept_by',       'label' => 'Kept By',        'type' => 'text',   'required' => true,  'width' => 'md', 'auto_user' => true],
            ['name' => 'kept_date',     'label' => 'Kept Date',      'type' => 'date',   'required' => true,  'width' => 'md'],
            ['name' => 'drawn_by',      'label' => 'Drawn By',       'type' => 'text',   'required' => true,  'width' => 'md'],
            ['name' => 'drawn_date',    'label' => 'Drawn Date',     'type' => 'date',   'required' => true,  'width' => 'md'],
            ['name' => 'balance',       'label' => 'Balance',        'type' => 'number', 'required' => true,  'width' => 'sm'],
            ['name' => 'remarks',       'label' => 'Remarks',        'type' => 'text',   'required' => false, 'width' => 'full', 'is_remarks' => true],
        ],
        // Fields filled by manager when approving
        'review_fields' => [
            ['name' => 'checked_by',     'label' => 'Checked By',     'type' => 'text', 'required' => true, 'auto_user' => true],
            ['name' => 'inventory_date', 'label' => 'Inventory Date', 'type' => 'date', 'required' => true],
        ],
    ],

    // ✅ To add a new logbook — just copy a block above and change the fields!

];