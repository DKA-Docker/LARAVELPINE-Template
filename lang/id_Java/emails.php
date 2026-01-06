<?php

return [
    'deliveries' => [
        'request_created' => [
            'subject' => 'Panjaluk Kiriman Digawe',
            'title' => 'Panjaluk Kiriman Digawe',
            'greeting' => 'Halo :name,',
            'intro' => 'Panjaluk kiriman sampeyan wis kasil digawe. Ing ngisor iki rincian pengajuan sampeyan.',
            'summary' => [
                'title' => 'Ringkesan Panjaluk',
                'request_name' => 'Jeneng Panjaluk',
                'created_at' => 'Digawe Ing',
                'urgency' => 'Urgensi',
                'status' => 'Status',
                'urgent_high' => 'Dhuwur',
                'urgent_normal' => 'Biasa',
                'status_draft' => 'Draf',
            ],
            'destinations' => [
                'title' => 'Tujuan (:count)',
                'no_address' => 'Alamat Ora Disedhiyakake',
                'no_packages' => 'Ora ana paket kadhaptar.',
                'units' => 'pcs',
                'weight_suffix' => 'kg',
            ],
            'footer' => [
                'thank_you' => 'Matur nuwun wis nggunakake :app.',
                'rights' => 'Kabeh hak dilindhungi.',
            ]
        ]
    ]
];
