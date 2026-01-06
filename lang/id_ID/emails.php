<?php

return [
    'deliveries' => [
        'request_created' => [
            'subject' => 'Permintaan Pengiriman Dibuat',
            'title' => 'Permintaan Pengiriman Dibuat',
            'greeting' => 'Halo :name,',
            'intro' => 'Permintaan pengiriman Anda telah berhasil dibuat. Berikut adalah rincian pengajuan Anda.',
            'summary' => [
                'title' => 'Ringkasan Permintaan',
                'request_name' => 'Nama Permintaan',
                'created_at' => 'Dibuat Pada',
                'urgency' => 'Urgensi',
                'status' => 'Status',
                'urgent_high' => 'Tinggi',
                'urgent_normal' => 'Normal',
                'status_draft' => 'Draf',
            ],
            'destinations' => [
                'title' => 'Tujuan (:count)',
                'no_address' => 'Alamat Tidak Disediakan',
                'no_packages' => 'Tidak ada paket terdaftar.',
                'units' => 'pcs',
                'weight_suffix' => 'kg',
            ],
            'footer' => [
                'thank_you' => 'Terima kasih telah menggunakan :app.',
                'rights' => 'Hak cipta dilindungi undang-undang.',
            ]
        ]
    ]
];
