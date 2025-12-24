<?php

namespace App\Livewire\Metronic\Frontends\Resources\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Privacy extends Component

{
    /**
     * Privacy policy sections data
     * Based on Play Store Developer privacy policy structure
     */
    public array $sections = [];

    public function mount(): void
    {
        // Initialize privacy policy sections
        $this->sections = [
            [
                'title' => 'Article 1: Introduction & Definitions / Pasal 1: Pendahuluan & Definisi',
                'content_en' => '
                    <p class="mb-4 text-justify">The <strong>Logistech Driver Application</strong> ("App") is a specialized tool designed exclusively for authorized logistics partners ("Drivers"). By installing and using this App, you acknowledge that this is a professional tool used for fleet management, shipment tracking, and electronic proof of delivery.</p>
                    <p class="text-justify"><strong>"Personal Data"</strong> refers to any information that can identify you as an individual, including but not limited to your precise location, device identifiers, and photographic evidence submitted during delivery operations.</p>',
                'content_id' => '
                     <p class="mb-4 text-justify"><strong>Aplikasi Pengemudi Logistech</strong> ("Aplikasi") adalah alat khusus yang dirancang eksklusif untuk mitra logistik resmi ("Pengemudi"). Dengan menginstal dan menggunakan Aplikasi ini, Anda mengakui bahwa ini adalah alat profesional yang digunakan untuk manajemen armada, pelacakan pengiriman, dan bukti pengiriman elektronik.</p>
                     <p class="text-justify"><strong>"Data Pribadi"</strong> mengacu pada informasi apa pun yang dapat mengidentifikasi Anda sebagai individu, termasuk namun tidak terbatas pada lokasi presisi Anda, pengenal perangkat, dan bukti foto yang dikirimkan selama operasi pengiriman.</p>'
            ],
            [
                'title' => 'Article 2: Location Information Permissions / Pasal 2: Izin Informasi Lokasi',
                'content_en' => '
                    <div class="space-y-4">
                        <p class="text-justify font-semibold text-primary">2.1. Background Location Tracking</p>
                        <p class="text-justify">To ensure the safety of shipments and efficiency of logistics operations, this App requires <strong>"Allow all the time"</strong> access to your location. This allows our servers to track your movement <strong>even when the App is running in the background, the screen is locked, or you are navigating using another map application</strong>.</p>
                        
                        <p class="text-justify font-semibold text-primary">2.2. Purpose of Collection</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                            <li><strong>Real-TimeETA:</strong> To provide accurate Estimated Time of Arrival updates to customers waiting for their packages.</li>
                            <li><strong>Route Optimization:</strong> To analyze traffic patterns and suggest the most fuel-efficient delivery routes.</li>
                            <li><strong>Geo-Validation:</strong> To systemically verify that a package was dropped off at the correct coordinate (Geofencing), preventing delivery disputes.</li>
                        </ul>
                    </div>',
                'content_id' => '
                    <div class="space-y-4">
                        <p class="text-justify font-semibold text-primary">2.1. Pelacakan Lokasi Latar Belakang</p>
                        <p class="text-justify">Untuk memastikan keamanan pengiriman dan efisiensi operasi logistik, Aplikasi ini memerlukan akses <strong>"Izinkan sepanjang waktu"</strong> ke lokasi Anda. Ini memungkinkan server kami melacak pergerakan Anda <strong>bahkan ketika Aplikasi berjalan di latar belakang, layar terkunci, atau Anda sedang menavigasi menggunakan aplikasi peta lain</strong>.</p>
                        
                        <p class="text-justify font-semibold text-primary">2.2. Tujuan Pengumpulan</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                            <li><strong>ETA Real-Time:</strong> Untuk memberikan pembaruan Perkiraan Waktu Tiba yang akurat kepada pelanggan yang menunggu paket mereka.</li>
                            <li><strong>Optimasi Rute:</strong> Untuk menganalisis pola lalu lintas dan menyarankan rute pengiriman yang paling hemat bahan bakar.</li>
                            <li><strong>Validasi Geo:</strong> Untuk memverifikasi secara sistematis bahwa paket diturunkan di koordinat yang benar (Geofencing), mencegah sengketa pengiriman.</li>
                        </ul>
                    </div>'
            ],
            [
                'title' => 'Article 3: Camera & Electronic Proof of Delivery (ePOD) / Pasal 3: Kamera & Bukti Pengiriman Elektronik',
                'content_en' => '
                     <div class="space-y-4">
                        <p class="text-justify">The App requires direct access to your device\'s Camera sensor. This permission is strictly utilized for operational requirements and <strong>Chain of Custody</strong> verification.</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                            <li><strong>Photographic Evidence:</strong> Drivers are required to capture photos of the delivered package at the recipient\'s doorstep or being held by the recipient. These photos serve as legal data points to resolve "Item Not Received" claims.</li>
                            <li><strong>Barcode/QR Scanning:</strong> The camera is used to instantly decode shipment labels (Waybills) to update package status in the system.</li>
                        </ul>
                        <p class="text-xs text-gray-500 italic">We do not access the camera for video conferencing or facial recognition surveillance.</p>
                     </div>',
                'content_id' => '
                     <div class="space-y-4">
                        <p class="text-justify">Aplikasi ini memerlukan akses langsung ke sensor Kamera perangkat Anda. Izin ini digunakan secara ketat untuk persyaratan operasional dan verifikasi <strong>Rantai Pengawasan (Chain of Custody)</strong>.</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                             <li><strong>Bukti Fotografi:</strong> Pengemudi diwajibkan untuk mengambil foto paket yang dikirimkan di depan pintu penerima atau dipegang oleh penerima. Foto-foto ini berfungsi sebagai poin data hukum untuk menyelesaikan klaim "Barang Tidak Diterima".</li>
                            <li><strong>Pemindaian Barcode/QR:</strong> Kamera digunakan untuk mendekode label pengiriman (Surat Jalan) secara instan untuk memperbarui status paket di sistem.</li>
                        </ul>
                        <p class="text-xs text-gray-500 italic">Kami tidak mengakses kamera untuk konferensi video atau pengawasan pengenalan wajah.</p>
                     </div>'
            ],
            [
                'title' => 'Article 4: Device Integrity & Security / Pasal 4: Integritas & Keamanan Perangkat',
                'content_en' => '
                     <div class="space-y-4">
                        <p class="text-justify">To maintain the integrity of our logistics network and prevent fraud, accessing Phone State and Storage permissions is necessary.</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                            <li><strong>Single Device Policy:</strong> We collect persistent device identifiers (IMEI/UUID) to enforce a policy where one driver account is bound to a single trusted device. This prevents unauthorized account sharing and credential theft.</li>
                            <li><strong>Offline Storage:</strong> If you are delivering in an area with poor signal, ePOD photos and location logs are stored locally (encrypted) and automatically synchronized once connectivity is restored.</li>
                        </ul>
                     </div>',
                'content_id' => '
                     <div class="space-y-4">
                        <p class="text-justify">Untuk menjaga integritas jaringan logistik kami dan mencegah penipuan, mengakses izin Status Telepon dan Penyimpanan sangat diperlukan.</p>
                        <ul class="list-disc pl-5 space-y-2 text-sm">
                            <li><strong>Kebijakan Satu Perangkat:</strong> Kami mengumpulkan pengenal perangkat persisten (IMEI/UUID) untuk menegakkan kebijakan di mana satu akun pengemudi terikat pada satu perangkat tepercaya. Ini mencegah pembagian akun yang tidak sah dan pencurian kredensial.</li>
                            <li><strong>Penyimpanan Offline:</strong> Jika Anda melakukan pengiriman di area dengan sinyal buruk, foto ePOD dan log lokasi disimpan secara lokal (dienkripsi) dan disinkronkan secara otomatis setelah konektivitas pulih.</li>
                        </ul>
                     </div>'
            ],
            [
                'title' => 'Article 5: Data Retention & User Rights / Pasal 5: Penyimpanan Data & Hak Pengguna',
                'content_en' => '
                     <div class="space-y-4">
                        <p class="text-justify">Operational data (Location logs) is retained for a period of <strong>90 days</strong> for audit and dispute resolution purposes. After this period, data is anonymized or permanently deleted.</p>
                        <p class="text-justify">As a partner, you have the right to request a copy of your operational history or request account deletion upon termination of your partnership, subject to legal retention obligations mandated by local transportation laws.</p>
                     </div>',
                'content_id' => '
                     <div class="space-y-4">
                        <p class="text-justify">Data operasional (Log lokasi) disimpan selama periode <strong>90 hari</strong> untuk tujuan audit dan penyelesaian sengketa. Setelah periode ini, data dianonimkan atau dihapus secara permanen.</p>
                        <p class="text-justify">Sebagai mitra, Anda berhak meminta salinan riwayat operasional Anda atau meminta penghapusan akun setelah pengakhiran kemitraan Anda, tunduk pada kewajiban penyimpanan hukum yang dimandatkan oleh undang-undang transportasi setempat.</p>
                     </div>'
            ],
            [
                'title' => 'Article 6: Contact & Grievance Officer / Pasal 6: Kontak & Petugas Pengaduan',
                'content_en' => '
                     <div class="space-y-2">
                        <p>For any privacy concerns, data breach reports, or permission inquiries, please contact our dedicated Data Protection Officer:</p>
                        <ul class="list-none space-y-1 text-sm font-medium">
                             <li><strong>Email:</strong> privacy@' . parse_url(config('app.url'), PHP_URL_HOST) . '</li>
                             <li><strong>Address:</strong> Logistech HQ, Jl. Logistics Raya No. 123, Jakarta</li>
                             <li><strong>Hotline:</strong> +62 812 3456 7890 (24/7 Driver Support)</li>
                        </ul>
                     </div>',
                'content_id' => '
                     <div class="space-y-2">
                        <p>Untuk masalah privasi, laporan pelanggaran data, atau pertanyaan izin, silakan hubungi Petugas Perlindungan Data khusus kami:</p>
                         <ul class="list-none space-y-1 text-sm font-medium">
                             <li><strong>Email:</strong> privacy@' . parse_url(config('app.url'), PHP_URL_HOST) . '</li>
                             <li><strong>Alamat:</strong> Logistech HQ, Jl. Logistics Raya No. 123, Jakarta</li>
                             <li><strong>Hotline:</strong> +62 812 3456 7890 (Dukungan Pengemudi 24/7)</li>
                        </ul>
                     </div>'
            ]
        ];
    }

    /**
     * @return Factory|View
     * Render the privacy policy component
     */
    public function render(): Factory|View
    {
        return view('frontends.resources.components.privacy');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="flex items-center justify-center min-h-screen">
            <div class="text-xl font-bold text-gray-500">Loading Privacy Policy...</div>
        </div>
        HTML;
    }
}
