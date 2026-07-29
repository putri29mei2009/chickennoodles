<?php
require_once 'config.php';

$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : null;
$order_details = null;
$order_items = [];

if ($order_id) {
    // Fetch order details
    $stmt_order = $conn->prepare("SELECT id, customer_name, customer_address, customer_phone, total_amount, order_status, created_at FROM orders WHERE id = ?");
    $stmt_order->bind_param("i", $order_id);
    $stmt_order->execute();
    $result_order = $stmt_order->get_result();
    $order_details = $result_order->fetch_assoc();

    if ($order_details) {
        // Fetch order items
        $stmt_items = $conn->prepare("SELECT oi.quantity, oi.price, p.name AS product_name, p.image AS product_image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();
        while ($row = $result_items->fetch_assoc()) {
            $order_items[] = $row;
        }
    }
    // Clear order_id from session after displaying
    unset($_SESSION['order_id']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Chickennoodles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1><a href="index.php">Chickennoodles</a></h1>
        </div>
    </header>

    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="user_cart.php">Keranjang</a></li>
                <li><a href="checkout.php">Checkout</a></li>

            </ul>
        </div>
    </nav>

    <main class="container">
        <h2>Konfirmasi Pesanan Anda</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <p style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if ($order_details): ?>
            <div class="order-confirmation-details">
                <h3>Detail Pesanan #<?php echo htmlspecialchars($order_details['id']); ?></h3>
                <p><strong>Nama Pelanggan:</strong> <?php echo htmlspecialchars($order_details['customer_name']); ?></p>
                <p><strong>Alamat Pengiriman:</strong> <?php echo htmlspecialchars($order_details['customer_address']); ?></p>
                <p><strong>Nomor Telepon:</strong> <?php echo htmlspecialchars($order_details['customer_phone']); ?></p>
                <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($order_details['total_amount'], 2, ',', '.'); ?></p>
                <p><strong>Status Pesanan:</strong> <?php echo htmlspecialchars($order_details['order_status']); ?></p>
                <p><strong>Tanggal Pesanan:</strong> <?php echo date('d-m-Y H:i:s', strtotime($order_details['created_at'])); ?></p>

                <h4>Item Pesanan:</h4>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td>
                                    <img src="assets/img/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="50" height="50">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td>Rp <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p style="text-align: center; margin-top: 20px;">Terima kasih telah berbelanja di Chickennoodles!</p>
            </div>
        <?php else: ?>
            <p style="text-align: center;">Tidak ada detail pesanan untuk ditampilkan atau pesanan tidak ditemukan.</p>
            <p style="text-align: center;"><a href="index.php" class="btn">Kembali ke Beranda</a></p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chickennoodles. Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
<?php
$conn->close();
?>