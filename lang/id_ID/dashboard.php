<?php


return [
    'search_modal' => [
        'placeholder' => 'Ketuk untuk memulai pencarian',
        'tabs' => [
            'mixed' => 'Campuran',
            'settings' => 'Pengaturan',
            'integrations' => 'Integrasi',
            'users' => 'Pengguna',
            'docs' => 'Dokumen',
            'empty' => 'Kosong',
            'no_results' => 'Tidak Ada Hasil',
        ],
        'items' => [
            'settings' => 'Pengaturan',
            'public_profile' => 'Profil Publik',
            'my_account' => 'Akun Saya',
            'devs_forum' => 'Forum Pengembang',
            'integrations' => 'Integrasi',
            'users' => 'Pengguna',
            'shortcuts' => 'Pintasan',
            'go_to_dashboard' => 'Ke Dasbor',
            'my_profile' => 'Profil Saya',
            'actions' => 'Tindakan',
            'create_user' => 'Buat Pengguna',
            'create_team' => 'Buat Tim',
            'change_plan' => 'Ubah Paket',
            'setup_branding' => 'Atur Branding',
            'go_to_apps' => 'Ke Aplikasi',
            'go_to_users' => 'Ke Pengguna',
            'view' => 'Lihat',
            'export' => 'Ekspor',
            'email' => 'Email',
            'sms' => 'SMS',
            'push' => 'Push',
            'edit' => 'Ubah',
            'delete' => 'Hapus',
        ],
        'status' => [
            'in_office' => 'Di Kantor',
            'on_leave' => 'Cuti',
            'remote' => 'Jarak Jauh',
        ],
        'content' => [
            'jira' => 'Jira',
            'project_management' => 'Manajemen Proyek',
            'inferno' => 'Inferno',
            'real_time_photo' => 'Aplikasi berbagi foto real-time',
            'evernote' => 'Evernote',
            'notes_app' => 'Aplikasi manajemen catatan',
            'gitlab' => 'Gitlab',
            'google_webdev' => 'Google webdev',
            'building_web' => 'Membangun pengalaman web',
            'empty_title' => 'Mencari sesuatu..',
            'empty_desc' => 'Mulai pengalaman digital Anda dengan dashboard intuitif kami',
            'no_results_title' => 'Tidak Ditemukan Hasil',
            'no_results_desc' => 'Persempit pencarian Anda untuk menemukan item yang relevan',
            'view_projects' => 'Lihat Proyek',
        ]
    ],
    'modals' => [
        'share' => [
            'title' => 'Bagikan Profil',
            'read_only' => 'Bagikan tautan baca-saja',
            'email' => 'Bagikan via email',
            'btn_share' => 'Bagikan',
            'owner' => 'Pemilik',
            'editor' => 'Editor',
            'viewer' => 'Pelihat',
            'settings' => 'Pengaturan',
            'anyone_view' => 'Siapapun di :company bisa melihat',
            'change_access' => 'Ubah Akses',
            'anyone_edit' => 'Siapapun dengan tautan bisa mengedit',
            'set_password' => 'Atur Kata Sandi',
            'done' => 'Selesai',
        ],
        'award' => [
            'title' => 'Berikan Penghargaan',
        ],
        'report' => [
            'title' => 'Laporkan Pengguna',
            'reason_title' => 'Beri tahu kami mengapa Anda melaporkan orang ini',
            'impersonation' => 'Penyamaran',
            'impersonation_desc' => 'Sepertinya profil ini mungkin menyamar sebagai orang lain',
            'spammy' => 'Spam',
            'spammy_desc' => 'Profil, komentar, atau postingan orang ini berisi teks yang menyesatkan',
            'abusive' => 'Perilaku Kasar',
            'abusive_desc' => 'Orang ini telah melakukan perilaku yang kasar atau perundungan',
            'other' => 'Lainnya',
            'other_desc' => 'Tidak ada alasan di atas yang sesuai',
            'anonymous_note' => "Jangan khawatir, laporan Anda sepenuhnya anonim; orang yang Anda laporkan tidak akan diberitahu bahwa Anda mengirimkannya",
            'submit' => 'Laporkan orang ini',
            'cancel' => 'Batal',
        ]
    ],
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
            'title' => 'Buat Permintaan Baru',
            'subtitle' => 'Lengkapi informasi pengiriman di bawah ini dengan detail.',
            'buttons' => [
                'cancel' => 'Batal',
                'save' => 'Simpan & Buat',
                'add_destination' => '+ Tambah Tujuan',
                'add_package' => '+ Tambah Paket',
                'finalize' => 'Finalisasi & Simpan Data',
            ],
            'sections' => [
                'info' => 'Informasi Permintaan Pengiriman',
                'destination_list' => 'Daftar Tujuan Pengiriman',
            ],
            'form' => [
                'subject_title' => 'Nama Subjek Pengiriman',
                'subject_desc' => 'Tentukan judul pengiriman Anda, contoh: <span class="italic font-medium text-indigo-600">"Logistics Delivery Cluster A"</span>. Judul ini memudahkan pelacakan data.',
                'input_title' => 'Judul Pengiriman',
                'input_title_placeholder' => 'Masukkan judul permintaan...',
                'input_urgency' => 'Tingkat Urgensi',
                'input_urgency_placeholder' => 'Contoh: Tinggi/Rendah',
                'empty_destination' => 'Belum Ada Tujuan',
                'empty_destination_desc' => 'Anda dapat menambahkan lebih dari satu titik pengiriman untuk permintaan ini.',
                'destination_recipient_empty' => 'Penerima Belum Diisi',
                'destination_address_empty' => 'Alamat pengiriman belum ditentukan',
                'destination_recipient_label' => 'Nama Penerima',
                'destination_recipient_placeholder' => 'Contoh: Bpk. Jaka',
                'destination_address_label' => 'Alamat Lengkap',
                'destination_address_placeholder' => 'Masukkan alamat tujuan...',
                'destination_note_label' => 'Catatan Tambahan',
                'destination_note_placeholder' => 'Detail pengiriman...',
                'empty_package' => 'Belum Ada Paket',
                'empty_package_desc' => 'Tambahkan item paket yang akan dikirim ke tujuan ini.',
                'box_header' => 'Informasi Paket',
                'package_name_label' => 'Nama Item',
                'package_name_placeholder' => 'Contoh: Kotak A',
                'package_qty_label' => 'Jumlah',
                'package_dimension_label' => 'Dimensi (cm)',
                'package_width_label' => 'Lebar (L)',
                'package_length_label' => 'Panjang (P)',
                'package_height_label' => 'Tinggi (T)',
                'package_weight_label' => 'Berat (kg)',
                'package_heavy_label' => 'Item Berat?',
                'package_heavy_yes' => 'Ya, Berat > 20kg',
                'package_heavy_no' => 'Tidak',
                'new_item' => 'Item Baru',
                'qty_suffix' => 'Jml',
                'item_count_suffix' => 'Item',
                'lat_label' => 'LAT',
                'lng_label' => 'LNG',
            ]
        ]
    ],
    'task' => [
        "heading" => "Tugas Pengiriman",
        'create' => [
            'title' => 'Buat Tugas Baru',
            'validation_error' => [
                'title' => 'Kesalahan Validasi',
                'message' => 'Gagal disimpan karena ada inputan tertentu belum di isi.',
            ],

            'region' => [
                'title' => 'Profil Wilayah',
                'destination_label' => 'Destinasi Penerima',
                'select_destination' => '-- Pilih Alamat Tujuan --',
                'province' => 'Provinsi',
                'select_province' => '-- Pilih Provinsi --',
                'city' => 'Kota/Kab',
                'select_city' => '-- Pilih Kota --',
                'district' => 'Kecamatan',
                'select_district' => '-- Pilih Kecamatan --',
                'village' => 'Desa/Kelurahan',
                'select_village' => '-- Pilih Desa --',
                'postal_code' => 'Kode Pos',
                'postal_code_placeholder' => 'Cth: 17211',
            ],
            'crew' => [
                'title' => 'Penugasan Kru',
                'list_label' => 'Daftar Personel',
                'empty_list' => 'Belum ada driver dipilih...',
                'search_placeholder' => 'Ketik nama driver...',
                'not_found' => 'Tidak Ditemukan',
                'add_button' => 'Tambah Driver',
            ],
            'vehicle' => [
                'category_label' => 'Pilih Kategori Kendaraan',
                'unit_label' => 'Pilih Unit Kendaraan',
                'select_unit' => '-- Pilih Unit --',
            ],
            'info' => [
                'title' => 'Info Utama & Geofencing',
                'subtitle' => 'Tentukan titik koordinat pengiriman',
                'task_name' => 'Nama Task / Pekerjaan',
                'task_name_placeholder' => 'Contoh: Pengiriman Elektronik Batch A',
                'search_location' => 'Cari Lokasi',
                'search_location_placeholder' => 'Cari Lokasi (Baca Saja)',
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'live_map' => 'Antarmuka Peta Langsung',
            ],
            'manifest' => [
                'title' => 'Manifest Inventaris',
                'destination' => 'Tujuan:',
                'total_qty' => 'Total Qty Keseluruhan',
                'show_items' => 'Tampilkan Item',
                'items' => 'Item',
            ],
            'table' => [
                'index' => 'Indeks',
                'product' => 'Deskripsi Produk',
                'unit' => 'Tipe Unit',
                'qty' => 'Kuantitas',
                'item_ref' => 'Ref Item:',
            ],
            'pagination' => [
                'page' => 'Halaman',
            ],
            'waiting' => [
                'title' => 'Menunggu Tujuan',
                'subtitle' => 'Silakan pilih destinasi untuk melihat manifest',
            ],
            'actions' => [
                'discard' => 'Buang Perubahan',
                'confirm' => 'Konfirmasi & Simpan Tugas',
                'synchronizing' => 'Sedang menyinkronkan...',
            ],
        ],
    ],
    'rates' => [
        'create' => [
             'validation_error' => [
                'title' => 'Kesalahan Validasi',
                'message' => 'Gagal disimpan karena ada inputan tertentu belum di isi.',
            ],
        ],
        'edit' => [
             'validation_error' => [
                'title' => 'Kesalahan Validasi',
                'message' => 'Gagal disimpan karena ada inputan tertentu belum di isi.',
            ],
        ]
    ],
    'tracking' => [
        'hud' => [
            'system_status' => 'Status Sistem',
            'online' => 'ONLINE',
            'active_units' => 'Unit Aktif',
            'time_sync' => 'Sinkronisasi Waktu Universal',
        ]
    ],
    'management' => [
        'accounts' => [
            'search_placeholder' => 'Cari akun...',
            'filter' => [
                'cust' => 'Pelanggan...',
                'recp' => 'Penerima...',
                'status_label' => 'Status',
                'status_options' => [
                    'todo' => 'To-Do',
                    'on_delivery' => 'Progress',
                    'delivered' => 'Terkirim',
                    'failed' => 'Gagal',
                    'done' => 'Selesai',
                ],
                'sort_label' => 'Urutkan',
                'sort_options' => [
                    'latest' => 'Terbaru',
                    'oldest' => 'Terlama',
                ],
                'clear' => 'Bersihkan'
            ],
            'table' => [
                'title' => 'Manajemen Akun',
                'showing' => 'Menampilkan',
                'from' => 'dari',
                'data' => 'data',
                'headers' => [
                    'profile' => 'Profil Pengguna',
                    'credential' => 'Kredensial',
                    'role' => 'Peran',
                    'device' => 'Perangkat',
                    'registered' => 'Terdaftar',
                    'action' => 'Aksi',
                ],
                'empty' => 'Data Kosong',
                'no_role' => 'Tanpa Peran',
                'status' => [
                    'active' => 'Aktif',
                    'off' => 'MATI',
                ]
            ],
            'footer' => [
                'limit' => 'Batas',
            ],
            'create' => [
                'title' => 'Buat Akun Baru',
                'security' => [
                    'title' => 'Kredensial Keamanan',
                    'subtitle' => 'Atur akses login pengguna',
                    'username' => 'Nama Pengguna',
                    'username_placeholder' => 'Nama Pengguna...',
                    'password' => 'Kata Sandi',
                    'password_placeholder' => '••••••••',
                    'confirm_password' => 'Konfirmasi Kata Sandi',
                ],
                'personal' => [
                    'title' => 'Informasi Pribadi',
                    'first_name' => 'Nama Depan',
                    'first_name_placeholder' => 'Nama Depan',
                    'last_name' => 'Nama Belakang',
                    'last_name_placeholder' => 'Nama Belakang',
                    'email' => 'Kontak Email',
                    'email_placeholder' => 'contoh@domain.com',
                ],
                'roles' => [
                    'title' => 'Penugasan Peran',
                    'clear_selection' => 'Hapus Pilihan',
                    'system_access' => 'Hak Akses Sistem',
                    'guard' => 'Guard: :name',
                ],
                'actions' => [
                    'discard' => 'Buang perubahan',
                    'create' => 'Buat Akun',
                    'processing' => 'Memproses...',
                    'error_title' => 'Kesalahan Validasi',
                ],
            ],
        ]
    ],
    'components' => [
        'overview' => [
            'stats' => [
                'request' => 'Permintaan Pengiriman',
                'sending' => 'Sedang Dikirim',
                'pending' => 'Pengiriman Tertunda',
                'finished' => 'Pengiriman Selesai',
            ],
            'chart' => [
                'demography' => 'Demografi Pengiriman',
                'select_province' => 'Pilih Provinsi',
                'select_regency' => 'Pilih Kota/Kab',
                'select_district' => 'Pilih Kecamatan',
                'select_village' => 'Pilih Kelurahan',
                'by_city' => 'Berdasarkan Kota',
                'by_district' => 'Berdasarkan Kecamatan',
                'by_village' => 'Berdasarkan Kelurahan',
                'logistics' => 'Tinjauan Logistik',
                'performance' => 'Kinerja Pengiriman',
                'last_7_days' => '7 Hari Terakhir',
                'last_30_days' => '30 Hari Terakhir',
            ]
        ]
    ]
];
