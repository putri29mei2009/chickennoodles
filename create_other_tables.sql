-- Use the chicken_noodles database
USE chicken_noodles;

-- Create the 'products' table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255), -- Stores the relative path to the image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'orders' tableZ
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, -- Optional, if users are logged in
    customer_name VARCHAR(255) NOT NULL,
    customer_address TEXT NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_status VARCHAR(50) DEFAULT 'pending', -- e.g., pending, completed, cancelled
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create the 'order_items' table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL, -- Price at the time of order
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

-- Optional: Insert sample products
INSERT INTO products (name, description, price, image) VALUES
('Mie Ayam Original', 'Mie ayam dengan topping ayam cincang gurih.', 15000.00, 'mie ayam original.jpg'),
('Mie Ayam Pangsit', 'Mie ayam dengan tambahan pangsit rebus.', 18000.00, 'mie ayam pangsit.jpg'),
('Mie Ayam Ceker', 'Mie ayam dengan tambahan ceker ayam empuk.', 20000.00, 'mie ayam ceker.jpg'),
('Mie Ayam Bakso', 'Mie ayam dengan tambahan bakso sapi kenyal.', 22000.00, 'mie ayam bakso.jpg');
