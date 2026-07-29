<?php
require_once 'config.php';

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja Anda - Chickennoodles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="index.php" class="logo-link">
                <span class="logo-emoji">🍜</span> <span class="logo-text">Chickennoodles Syafira</span>
            </a>
        </div>
    </header>

    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="user_cart.php">🛒 Keranjang</a></li>
                <li><a href="checkout.php">Checkout</a></li>


            </ul>
        </div>
    </nav>

    <main class="container">
        <h2>Keranjang Belanja Anda</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <p style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if (!empty($cart_items)): ?>
            <form action="update_cart.php" method="post">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $product_id => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total_price += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <img src="assets/img/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50" height="50">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </td>
                                <td>Rp <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                                <td>
                                    <input type="number" name="quantities[<?php echo $product_id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                                </td>
                                <td>Rp <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                                <td>
                                    <button type="submit" name="remove_item" value="<?php echo $product_id; ?>" class="btn" style="background-color: #D32F2F;">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="text-align: right; margin-top: 15px;">
                    <button type="submit" name="update_cart" class="btn">Perbarui Keranjang</button>
                </div>
            </form>

            <div class="cart-total">
                Total: Rp <?php echo number_format($total_price, 2, ',', '.'); ?>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="checkout.php" class="btn btn-primary">Lanjutkan ke Checkout</a>
                <a href="update_cart.php?action=clear_cart" class="btn" style="background-color: #555;">Bersihkan Keranjang</a>
            </div>

        <?php else: ?>
            <p>Keranjang belanja Anda kosong. <a href="index.php">Mulai belanja sekarang!</a></p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Chickennoodles. Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
