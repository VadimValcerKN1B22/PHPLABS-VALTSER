<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управління продажами</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .report { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Система управління продажами</h1>
        
        <!-- Форма для додавання замовлення -->
        <h2>Додати нове замовлення (Панель адміністратора)</h2>
        <form method="POST" action="index.php">
            <label for="customer_id">Клієнт:</label>
            <select name="customer_id" required>
                <option value="">Оберіть клієнта</option>
                <?php
                $conn = new mysqli("localhost", "username", "password", "sales_db");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $result = $conn->query("SELECT customer_id, name FROM customers");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['customer_id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <label for="product_id">Товар:</label>
            <select name="product_id" required>
                <option value="">Оберіть товар</option>
                <?php
                $result = $conn->query("SELECT product_id, name FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['product_id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <label for="quantity">Кількість:</label>
            <input type="number" name="quantity" min="1" required>

            <button type="submit" name="add_order">Додати замовлення</button>
        </form>

        <?php
        if (isset($_POST['add_order'])) {
            $customer_id = $_POST['customer_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Отримання ціни товару
            $result = $conn->query("SELECT price FROM products WHERE product_id = $product_id");
            $product = $result->fetch_assoc();
            $total_price = $product['price'] * $quantity;

            // Додавання замовлення
            $sql = "INSERT INTO orders (customer_id, product_id, quantity, total_price, order_date) 
                    VALUES ($customer_id, $product_id, $quantity, $total_price, NOW())";
            if ($conn->query($sql) === TRUE) {
                echo "<p style='color: green;'>Замовлення успішно додано!</p>";
            } else {
                echo "<p style='color: red;'>Помилка: " . $conn->error . "</p>";
            }
        }
        ?>

        <!-- Форма для звіту -->
        <h2>Звіт про продажі</h2>
        <form method="POST" action="index.php">
            <label for="start_date">Дата початку:</label>
            <input type="date" name="start_date" required>
            <label for="end_date">Дата закінчення:</label>
            <input type="date" name="end_date" required>
            <button type="submit" name="generate_report">Згенерувати звіт</button>
        </form>

        <?php
        if (isset($_POST['generate_report'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $sql = "SELECT p.name, SUM(o.quantity) as total_quantity, SUM(o.total_price) as total_sales
                    FROM orders o
                    JOIN products p ON o.product_id = p.product_id
                    WHERE o.order_date BETWEEN '$start_date' AND '$end_date'
                    GROUP BY p.product_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='report'>";
                echo "<h3>Звіт про продажі за період $start_date - $end_date</h3>";
                echo "<table>";
                echo "<tr><th>Товар</th><th>Кількість</th><th>Сума продажів</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['name']}</td><td>{$row['total_quantity']}</td><td>{$row['total_sales']} грн</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>Немає даних за обраний період.</p>";
            }
        }
        $conn->close();
        ?>
    </div>
</body>
</html>