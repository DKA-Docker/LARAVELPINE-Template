<?php

return [
    'deliveries' => [
        'request_created' => [
            'subject' => 'Delivery Request Created',
            'title' => 'Delivery Request Created',
            'greeting' => 'Dear :name,',
            'intro' => 'Your delivery request has been successfully created. Below are the details of your submission.',
            'summary' => [
                'title' => 'Request Summary',
                'request_name' => 'Request Name',
                'created_at' => 'Created At',
                'urgency' => 'Urgency',
                'status' => 'Status',
                'urgent_high' => 'High',
                'urgent_normal' => 'Normal',
                'status_draft' => 'Draft',
            ],
            'destinations' => [
                'title' => 'Destinations (:count)',
                'no_address' => 'No Address Provided',
                'no_packages' => 'No packages listed.',
                'units' => 'pcs',
                'weight_suffix' => 'kg',
            ],
            'footer' => [
                'thank_you' => 'Thank you for using :app.',
                'rights' => 'All rights reserved.',
            ]
        ]
    ]
];
