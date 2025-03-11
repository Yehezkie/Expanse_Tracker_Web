<?php
include 'db.php';

// Ambil data transaksi dari database
$sql = "SELECT * FROM transactions ORDER BY date DESC";
$stmt = $conn->query($sql);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total pengeluaran per bulan
$monthlyExpenses = [];
foreach ($transactions as $transaction) {
    if ($transaction['type'] == 'expense') {
        $month = date('Y-m', strtotime($transaction['date'])); // Ambil tahun dan bulan (format: Y-m)
        if (!isset($monthlyExpenses[$month])) {
            $monthlyExpenses[$month] = 0;
        }
        $monthlyExpenses[$month] += $transaction['amount'];
    }
}

// Set header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="transactions.csv"');

// Buka output stream
$output = fopen('php://output', 'w');

// Tulis header CSV
fputcsv($output, ['ID', 'Tanggal', 'Jenis', 'Deskripsi', 'Jumlah']);

// Tulis data transaksi ke CSV
foreach ($transactions as $transaction) {
    fputcsv($output, [
        $transaction['id'],
        $transaction['date'],
        $transaction['type'],
        $transaction['description'],
        number_format($transaction['amount'], 2) // Format jumlah dengan 2 digit desimal
    ]);
}

// Tambahkan baris kosong untuk pemisah
fputcsv($output, []);

// Tulis total pengeluaran per bulan
fputcsv($output, ['Laporan Pengeluaran per Bulan']);
fputcsv($output, ['Bulan', 'Total Pengeluaran']);
foreach ($monthlyExpenses as $month => $total) {
    fputcsv($output, [
        $month,
        number_format($total, 2) // Format total dengan 2 digit desimal
    ]);
}

fclose($output);
exit;
?>