USE if0_39166719_sales_db;

CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    product_id INT,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date DATETIME NOT NULL,
    execution_date DATE NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Очищення таблиць перед вставкою тестових даних
TRUNCATE TABLE orders;
TRUNCATE TABLE customers;
TRUNCATE TABLE products;

-- Додавання тестових даних (5 клієнтів і 5 товарів техніки)
INSERT INTO customers (name, email, phone) VALUES 
('Іван Петров', 'ivan@example.com', '1234567890'),
('Марія Коваленко', 'maria@example.com', '0987654321'),
('Олег Сидоренко', 'oleg@example.com', '0671234567'),
('Анна Шевченко', 'anna@example.com', '0509876543'),
('Павло Зінченко', 'pavlo@example.com', '0934567890');

INSERT INTO products (name, price) VALUES 
('Ноутбук ASUS', 15000.00),
('Смартфон Samsung', 8000.00),
('Планшет Apple iPad', 12000.00),
('Монітор Dell 27"', 10000.00),
('Навушники Sony', 3000.00);