<?php
/**
 * index.php
 * Halaman utama — Kedai Kopi Ranting
 * Logika PHP dipisahkan dari tampilan (HTML), styling (CSS), dan perilaku (JS)
 */

// ------------------------------------------------------------
// 1) Data statis untuk menu (biasanya bisa berasal dari database)
// ------------------------------------------------------------
$menu = [
    ['nama' => 'Kopi Tubruk',        'deskripsi' => 'Kopi robusta lokal, diseduh kasar ala rumahan.', 'harga' => 12000],
    ['nama' => 'Kopi Susu Gula Aren','deskripsi' => 'Espresso, susu segar, gula aren cair.',            'harga' => 18000],
    ['nama' => 'Americano',          'deskripsi' => 'Espresso ganda dengan air panas.',                  'harga' => 16000],
    ['nama' => 'Cappuccino',         'deskripsi' => 'Espresso, susu steam, busa tebal.',                  'harga' => 20000],
];

// ------------------------------------------------------------
// 2) Status buka/tutup berdasarkan jam server (contoh logika PHP dinamis)
// ------------------------------------------------------------
date_default_timezone_set('Asia/Jakarta');
$jamSekarang = (int) date('H');
$buka = ($jamSekarang >= 8 && $jamSekarang < 22);
$statusText = $buka ? 'Buka sekarang' : 'Tutup sekarang';

// ------------------------------------------------------------
// 3) Proses form kontak/pemesanan (jika dikirim lewat POST)
// ------------------------------------------------------------
$errors = [];
$success = false;
$old = ['nama' => '', 'email' => '', 'pesan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_pesan'])) {
    $old['nama']  = trim($_POST['nama'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['pesan'] = trim($_POST['pesan'] ?? '');

    if ($old['nama'] === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if ($old['pesan'] === '') {
        $errors[] = 'Pesan tidak boleh kosong.';
    }

    if (empty($errors)) {
        // Di sini biasanya pesan disimpan ke database atau dikirim via email.
        // Untuk contoh sederhana ini, kita cukup tandai sebagai berhasil.
        $success = true;
        $old = ['nama' => '', 'email' => '', 'pesan' => ''];
    }
}

$tahun = date('Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kedai Kopi Ranting</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="#beranda" class="logo">Ranting<span>.</span></a>
        <nav class="nav" id="navMenu">
            <a href="#menu">Menu</a>
            <a href="#tentang">Tentang</a>
            <a href="#kontak">Kontak</a>
        </nav>
        <button class="nav-toggle" id="navToggle" aria-label="Buka menu navigasi" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<main>
    <!-- HERO -->
    <section id="beranda" class="hero">
        <div class="container hero-inner">
            <div class="hero-text">
                <p class="hero-status <?= $buka ? 'is-open' : 'is-closed' ?>">
                    <span class="status-dot"></span> <?= htmlspecialchars($statusText) ?>
                </p>
                <h1>Secangkir kopi,<br>sepenggal jeda.</h1>
                <p class="hero-lede">
                    Kedai kecil di pinggir jalan yang menyeduh kopi robusta dan arabika
                    lokal setiap pagi. Tidak ada yang tergesa di sini.
                </p>
                <a href="#menu" class="btn btn-primary">Lihat menu</a>
            </div>
            <div class="hero-art" aria-hidden="true">
                <svg viewBox="0 0 320 320" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="160" cy="160" r="150" fill="none" stroke="var(--gold)" stroke-width="1.5" opacity="0.5"/>
                    <circle cx="160" cy="160" r="115" fill="none" stroke="var(--gold)" stroke-width="1.5" opacity="0.35"/>
                    <circle cx="160" cy="160" r="80"  fill="var(--espresso)" opacity="0.9"/>
                    <path d="M120 140 q40 -30 80 0" stroke="var(--cream)" stroke-width="4" fill="none" stroke-linecap="round" opacity="0.7"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- MENU -->
    <section id="menu" class="menu">
        <div class="container">
            <h2>Menu hari ini</h2>
            <ul class="menu-list">
                <?php foreach ($menu as $item): ?>
                <li class="menu-item">
                    <div class="menu-item-head">
                        <span class="menu-item-name"><?= htmlspecialchars($item['nama']) ?></span>
                        <span class="menu-item-dots" aria-hidden="true"></span>
                        <span class="menu-item-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                    </div>
                    <p class="menu-item-desc"><?= htmlspecialchars($item['deskripsi']) ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="tentang">
        <div class="container tentang-inner">
            <h2>Tentang Ranting</h2>
            <p>
                Ranting dimulai tahun 2019 dari garasi rumah yang diubah jadi tempat
                nongkrong tiga meja. Kami memilih biji kopi langsung dari petani di
                Gayo dan Kintamani, lalu menyangrai dalam jumlah kecil setiap minggu
                supaya rasanya tetap segar.
            </p>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="kontak">
        <div class="container kontak-inner">
            <div class="kontak-info">
                <h2>Kirim pesan</h2>
                <p>Ada pertanyaan soal pemesanan dalam jumlah besar atau kerja sama? Tulis di sini.</p>
                <ul class="kontak-detail">
                    <li>Jl. Kenanga No. 12, Pontianak</li>
                    <li>buka@rantingkopi.example</li>
                    <li>Setiap hari, 08.00–22.00</li>
                </ul>
            </div>

            <form class="kontak-form" method="post" action="#kontak" novalidate>
                <?php if ($success): ?>
                    <p class="form-alert form-alert-success">Terima kasih, pesan Anda sudah terkirim.</p>
                <?php elseif (!empty($errors)): ?>
                    <p class="form-alert form-alert-error">
                        <?php foreach ($errors as $err): ?>
                            <?= htmlspecialchars($err) ?><br>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($old['nama']) ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>">

                <label for="pesan">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4"><?= htmlspecialchars($old['pesan']) ?></textarea>

                <button type="submit" name="kirim_pesan" class="btn btn-primary">Kirim pesan</button>
            </form>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; <?= $tahun ?> Kedai Kopi Ranting.</p>
        <button id="backToTop" class="back-to-top" aria-label="Kembali ke atas">↑</button>
    </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>