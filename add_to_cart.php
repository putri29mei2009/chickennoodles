<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Fetch product details to ensure it's valid and get its price/name
    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add product to cart or update quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
        $_SESSION['message'] = "Produk '" . htmlspecialchars($product['name']) . "' telah ditambahkan ke keranjang.";
    } else {
        $_SESSION['message'] = "Produk tidak ditemukan.";
    }
} else {
    $_SESSION['message'] = "Permintaan tidak valid.";
}

// Redirect back to the product listing or cart page
header('Location: index.php'); // Or 'user_cart.php'
exit;
?>
