<?php 

session_start();
$dataAwal = false;

if (isset($_POST['btn-submit'])) {
    $nama = $_POST['nama'];
    $judul = $_POST['judul'];
    $tahun = $_POST['tahun'];
    $pengarang = $_POST['pengarang'];
    $tanggal = $_POST['tanggal'];

    // Hitung tanggal kembali dengan menambahkan 7 hari
    $tanggalPinjam = new DateTime($tanggal);
    $tanggalKembali = $tanggalPinjam->add(new DateInterval('P7D'))->format('Y-m-d');

    if (isset($_SESSION['perpustakaan'])) {
        foreach ($_SESSION['perpustakaan'] as $data) {
            if ($data['nama'] == $nama && $data['judul'] == $judul && $data['tahun'] == $tahun && $data['pengarang'] == $pengarang && $data['tanggal'] == $tanggal) {
                $dataAwal = true;
                break;
            }
        }
    }

    if (!$dataAwal) {
        $_SESSION['perpustakaan'][] = [
            "nama" => $nama,
            "judul" => $judul,
            "tahun" => $tahun,
            "pengarang" => $pengarang,
            "tanggal" => $tanggal,
            "tanggalKembali" => $tanggalKembali,
        ];
    }
}

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Perpustakaan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    @media print {
        .form-input, .button {
            display: none;
        }
        .form-output {
            display: block;
        }
    }
</style>
</head>
<body>
<div class="container mt-3">
    <h2 class="text-center mt-5 mb-5">Perpustakaan Online</h2>
    <form action="" method="post">
        <div class="form-input">
            <input class="form-control form-control-lg mb-3" type="text" name="nama" placeholder="Masukkan Nama" aria-label=".form-control-lg example" required>
            <input class="form-control form-control-lg mb-3" type="text" name="judul" placeholder="Judul Buku" aria-label=".form-control-lg example" required>
            <input class="form-control form-control-lg mb-3" type="number" name="tahun" placeholder="Tahun Buku" aria-label=".form-control-lg example" required>
            <input class="form-control form-control-lg mb-3" type="text" name="pengarang" placeholder="Pengarang" aria-label=".form-control-lg example" required>
            <input class="form-control form-control-lg mb-3" type="date" name="tanggal" placeholder="Tanggal Peminjaman" aria-label=".form-control-lg example" required>
        </div>
        <div class="button mt-3">
            <button type="submit" class="btn btn-primary" name="btn-submit"><i class="fa-solid fa-address-book"></i> Submit</button>
            <button type="button" class="btn btn-success" name="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak</button>
        </div>
    </form>

    <div class="form-output mt-4">
        <hr>
        <thead class="row align-items-start">
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">Nama Peminjam</div>
                <div class="col">Judul Buku</div>
                <div class="col">Tahun Buku</div>   
                <div class="col">Pengarang</div>
                <div class="col">Tanggal Pinjam</div>
                <div class="col">Tanggal Kembali</div>
                <div class="col">Action</div>
                <hr class="mt-3">    
            </div>
        </div>
        </thead>
        <tbody>
        <div class="container text-center">
        <?php
        if (isset($_SESSION['perpustakaan']) && is_array($_SESSION['perpustakaan'])) : 
            foreach ($_SESSION['perpustakaan'] as $key => $data) : ?>
                <div class="row align-items-start mt-3">
                    <div class="col"><?=htmlspecialchars($data['nama'])?></div>
                    <div class="col"><?=htmlspecialchars($data['judul'])?></div>
                    <div class="col"><?=htmlspecialchars($data['tahun'])?></div>
                    <div class="col"><?=htmlspecialchars($data['pengarang'])?></div>
                    <div class="col"><?=htmlspecialchars($data['tanggal'])?></div>
                    <div class="col"><?=htmlspecialchars($data['tanggalKembali'])?></div>
                    <div class="col"><a href="hapusData.php?id=<?= $key; ?>"><button type="submit" class="btn btn-danger" name="btn-delete">Hapus</button></a></div>
                    <hr class="mt-3">
                </div>
            <?php endforeach; 
        else : ?>
            <div class="row">
                <div class="col">Tidak ada data</div>
            </div>
        <?php endif; ?>
        </tbody>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
