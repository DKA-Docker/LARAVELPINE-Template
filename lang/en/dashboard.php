<?php


return [
    'request' => [
        "heading" => "Request Delivery",
        "data" => [
            "subtitle" => [
                "all" => "All",
                "accepted" => "Accepted",
                "rejected" => "Rejected",
            ]
        ],
        'create' => [
            'title' => 'Create New Request',
            'subtitle' => 'Complete the delivery information below in detail.',
            'buttons' => [
                'cancel' => 'Cancel',
                'save' => 'Save & Create',
                'add_destination' => '+ Add Destination',
                'add_package' => '+ Add Package',
                'finalize' => 'Finalize & Save Data',
            ],
            'sections' => [
                'info' => 'Delivery Request Information',
                'destination_list' => 'Delivery Destinations List',
            ],
            'form' => [
                'subject_title' => 'Create Delivery Subject Name',
                'subject_desc' => 'Determine your delivery title, example: <span class="italic font-medium text-indigo-600">"Logistics Delivery Cluster A"</span>. This title eases data tracking.',
                'input_title' => 'Delivery Title',
                'input_title_placeholder' => 'Enter request title...',
                'input_urgency' => 'Urgency Level',
                'input_urgency_placeholder' => 'Example: High/Low',
                'empty_destination' => 'No Destinations Yet',
                'empty_destination_desc' => 'You can add more than one delivery point for this request.',
                'destination_recipient_empty' => 'Recipient Not Filled',
                'destination_address_empty' => 'Delivery address not determined',
                'destination_recipient_label' => 'Recipient Name',
                'destination_recipient_placeholder' => 'Example: Mr. Jake',
                'destination_address_label' => 'Full Address',
                'destination_address_placeholder' => 'Enter destination address...',
                'destination_note_label' => 'Additional Notes',
                'destination_note_placeholder' => 'Delivery details...',
                'empty_package' => 'No Packages Yet',
                'empty_package_desc' => 'Add package items to be delivered to this destination.',
                'box_header' => 'Package Information',
                'package_name_label' => 'Item Name',
                'package_name_placeholder' => 'Example: Box A',
                'package_qty_label' => 'Quantity',
                'package_dimension_label' => 'Dimension (cm)',
                'package_width_label' => 'Width (W)',
                'package_length_label' => 'Length (L)',
                'package_height_label' => 'Height (H)',
                'package_weight_label' => 'Weight (kg)',
                'package_heavy_label' => 'Heavy Item?',
                'package_heavy_yes' => 'Yes, Weight > 20kg',
                'package_heavy_no' => 'No',
            ]
        ]
    ],
    'task' => [
        "heading" => "Delivery Task",
    ]
];
