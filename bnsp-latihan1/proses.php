<?php
require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = $_POST["id"] ?? "";
$nama = trim($_POST["nama"] ?? "");
$alamat = trim($_POST["alamat"] ?? "");
$tempatLahir = trim($_POST["tempat_lahir"] ?? "");
$tanggalLahir = $_POST["tanggal_lahir"] ?? "";
$paketBelajar = $_POST["paket_belajar"] ?? "";

$pilihanPaket = ["Paket A", "Paket B", "Paket C"];

if (
    $nama === "" || $alamat === "" || $tempatLahir === "" ||
    $tanggalLahir === "" || !in_array($paketBelajar, $pilihanPaket, true)
) {
    die("Data belum lengkap atau pilihan paket tidak valid. <a href='index.php'>Kembali</a>");
}

if ($id !== "") {
    $sql = "UPDATE siswa
            SET nama = ?, alamat = ?, tempat_lahir = ?,
                tanggal_lahir = ?, paket_belajar = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $alamat, $tempatLahir, $tanggalLahir, $paketBelajar, $id]);
} else {
    $sql = "INSERT INTO siswa
            (nama, alamat, tempat_lahir, tanggal_lahir, paket_belajar)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $alamat, $tempatLahir, $tanggalLahir, $paketBelajar]);
}

header("Location: index.php");
exit;
?>
