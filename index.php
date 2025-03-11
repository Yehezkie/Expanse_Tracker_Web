<?php
include 'db.php';

// Inisialisasi variabel
$balance = 0;
$income = 0;
$expense = 0;
$transactions = [];

try {
    // Ambil data transaksi dari database
    $sql = "SELECT * FROM transactions ORDER BY date DESC";
    $stmt = $conn->query($sql);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Hitung saldo, pemasukan, dan pengeluaran
    foreach ($transactions as $transaction) {
        if ($transaction['type'] == 'income') {
            $income += $transaction['amount'];
        } else {
            $expense += $transaction['amount'];
        }
    }

    $balance = $income - $expense;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Tampilkan pesan error jika query gagal
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Expense Tracker</h1>

        <!-- Card untuk Saldo, Pemasukan, dan Pengeluaran -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Saldo</h5>
                        <p class="card-text">Rp <?= number_format($balance, 2) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pemasukan</h5>
                        <p class="card-text">Rp <?= number_format($income, 2) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran</h5>
                        <p class="card-text">Rp <?= number_format($expense, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Tambah Transaksi dan Export -->
        <div class="d-flex justify-content-between mb-4">
            <a href="add_transaction.php" class="btn btn-primary">Tambah Transaksi</a>
            <div>
                <a href="export_csv.php" class="btn btn-success">Export ke CSV</a>
                <a href="export_pdf.php" class="btn btn-danger">Export ke PDF</a>
            </div>
        </div>

        <!-- Tabel Daftar Transaksi -->
        <h2 class="mb-3">Daftar Transaksi</h2>
        <?php if (!empty($transactions)): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction['date'] ?></td>
                    <td><?= $transaction['description'] ?></td>
                    <td>
                        <span class="badge <?= $transaction['type'] == 'income' ? 'bg-success' : 'bg-danger' ?>">
                            <?= $transaction['type'] ?>
                        </span>
                    </td>
                    <td>Rp <?= number_format($transaction['amount'], 2) ?></td>
                    <td>
                        <a href="delete_transaction.php?id=<?= $transaction['id'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">Tidak ada transaksi.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (opsional, jika menggunakan komponen interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>