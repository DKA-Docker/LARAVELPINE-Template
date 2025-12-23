<?php


return [
    'request' => [
        "heading" => "Permintaan Pengiriman",
        "data" => [
            "subtitle" => [
                "all" => "Semua",
                "accepted" => "Diterima",
                "rejected" => "Ditolak",
            ]
        ],
        'create' => [
            'title' => 'Buat Data Request Baru',
            'subtitle' => 'Lengkapi informasi pengiriman di bawah ini secara mendetail.',
            'buttons' => [
                'cancel' => 'Batalkan',
                'save' => 'Simpan & Buat Data',
                'add_destination' => '+ Tambah Destinasi',
                'add_package' => '+ Tambah Paket',
                'finalize' => 'Finalisasi & Simpan Data',
            ],
            'sections' => [
                'info' => 'Informasi Permintaan Pengiriman',
                'destination_list' => 'Daftar Destinasi Pengiriman',
            ],
            'form' => [
                'subject_title' => 'Buat Nama Subject Pengiriman',
                'subject_desc' => 'Tentukan judul pengiriman Anda, contoh: <span class="italic font-medium text-indigo-600">"Pengiriman Logistik Cluster A"</span>. Judul ini memudahkan pelacakan data.',
                'input_title' => 'Judul Pengiriman',
                'input_title_placeholder' => 'Masukkan judul permintaan...',
                'input_urgency' => 'Tingkat Urgensi',
                'input_urgency_placeholder' => 'Contoh: High/Low',
                'empty_destination' => 'Belum Ada Destinasi',
                'empty_destination_desc' => 'Anda bisa menambahkan lebih dari satu titik pengiriman untuk permintaan ini.',
                'destination_recipient_empty' => 'Penerima Belum Diisi',
                'destination_address_empty' => 'Alamat pengiriman belum ditentukan',
                'destination_recipient_label' => 'Nama Penerima',
                'destination_recipient_placeholder' => 'Contoh: Bpk. Jaka',
                'destination_address_label' => 'Alamat Lengkap',
                'destination_address_placeholder' => 'Masukkan alamat tujuan...',
                'destination_note_label' => 'Catatan Tambahan',
                'destination_note_placeholder' => 'Keterangan pengiriman...',
                'empty_package' => 'Belum Ada Paket',
                'empty_package_desc' => 'Tambahkan item paket yang akan dikirimkan ke destinasi ini.',
                'box_header' => 'Informasi Paket',
                'package_name_label' => 'Nama Barang',
                'package_name_placeholder' => 'Contoh: Kardus A',
                'package_qty_label' => 'Jumlah',
                'package_dimension_label' => 'Dimensi (cm)',
                'package_width_label' => 'Lebar (W)',
                'package_length_label' => 'Panjang (L)',
                'package_height_label' => 'Tinggi (H)',
                'package_weight_label' => 'Berat (kg)',
                'package_heavy_label' => 'Barang Berat?',
                'package_heavy_yes' => 'Ya, Berat > 20kg',
                'package_heavy_no' => 'Tidak',
            ]
        ]
    ],
    'task' => [
        "heading" => "Penugasan pengiriman",
    ]
];
