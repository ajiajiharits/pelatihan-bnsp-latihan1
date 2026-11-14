<?php
require "koneksi.php";

$edit = false;
$siswaEdit = [
    "id" => "",
    "nama" => "",
    "alamat" => "",
    "tempat_lahir" => "",
    "tanggal_lahir" => "",
    "paket_belajar" => ""
];

if (isset($_GET["edit"])) {
    $edit = true;
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->execute([$_GET["edit"]]);
    $data = $stmt->fetch();

    if ($data) {
        $siswaEdit = $data;
    } else {
        $edit = false;
    }
}

$stmt = $pdo->query("SELECT * FROM siswa ORDER BY id DESC");
$daftarSiswa = $stmt->fetchAll();

function e($nilai) {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pendaftaran Siswa</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            margin: 0;
            padding: 25px;
            color: #222;
        }
        .container {
            max-width: 950px;
            margin: auto;
        }
        h1 { color: #173b68; }
        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 22px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        label { display: block; margin: 13px 0 6px; font-weight: bold; }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd2dc;
            border-radius: 6px;
            font-size: 15px;
        }
        textarea { min-height: 75px; resize: vertical; }
        button, .btn {
            display: inline-block;
            border: 0;
            border-radius: 6px;
            padding: 10px 15px;
            color: white;
            background: #1769aa;
            text-decoration: none;
            cursor: pointer;
            margin-top: 15px;
            font-size: 14px;
        }
        .btn-edit { background: #d18b00; margin: 0; }
        .btn-delete { background: #c0392b; margin: 0; }
        .btn-cancel { background: #687386; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th, td { padding: 11px; border-bottom: 1px solid #e2e6ec; text-align: left; }
        th { background: #edf3f9; }
        .aksi { white-space: nowrap; }
        .kosong { color: #687386; }
    </style>
</head>
<body>
<div class="container">
    <h1>Aplikasi Pendaftaran Siswa</h1>
    <p>Formulir pendaftaran siswa menggunakan PHP dan MySQL.</p>

    <div class="card">
        <h2><?= $edit ? "Edit Data Siswa" : "Form Pendaftaran Siswa" ?></h2>

        <form action="proses.php" method="POST">
            <input type="hidden" name="id" value="<?= e($siswaEdit["id"]) ?>">

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama"
                   value="<?= e($siswaEdit["nama"]) ?>" required>

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" required><?= e($siswaEdit["alamat"]) ?></textarea>

            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir"
                   value="<?= e($siswaEdit["tempat_lahir"]) ?>" required>

            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                   value="<?= e($siswaEdit["tanggal_lahir"]) ?>" required>

            <label for="paket_belajar">Paket Belajar</label>
            <select id="paket_belajar" name="paket_belajar" required>
                <option value="">-- Pilih Paket Belajar --</option>
                <?php
                $paket = ["Paket A", "Paket B", "Paket C"];
                foreach ($paket as $pilihan):
                ?>
                    <option value="<?= e($pilihan) ?>"
                        <?= $siswaEdit["paket_belajar"] === $pilihan ? "selected" : "" ?>>
                        <?= e($pilihan) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"><?= $edit ? "Simpan Perubahan" : "Daftarkan Siswa" ?></button>
            <?php if ($edit): ?>
                <a class="btn btn-cancel" href="index.php">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h2>Data Siswa Terdaftar</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>TTL</th>
                        <th>Paket Belajar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($daftarSiswa) > 0): ?>
                    <?php foreach ($daftarSiswa as $nomor => $siswa): ?>
                    <tr>
                        <td><?= $nomor + 1 ?></td>
                        <td><?= e($siswa["nama"]) ?></td>
                        <td><?= e($siswa["alamat"]) ?></td>
                        <td><?= e($siswa["tempat_lahir"]) ?>,
                            <?= date("d-m-Y", strtotime($siswa["tanggal_lahir"])) ?></td>
                        <td><?= e($siswa["paket_belajar"]) ?></td>
                        <td class="aksi">
                            <a class="btn btn-edit" href="index.php?edit=<?= e($siswa["id"]) ?>">Edit</a>
                            <a class="btn btn-delete"
                               href="hapus.php?id=<?= e($siswa["id"]) ?>"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="kosong">Belum ada data siswa.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
