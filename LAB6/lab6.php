<?php
$mysqli = new mysqli("localhost", "root", "", "orders");

if ($mysqli->connect_error) {
    die("Помилка з'єднання з БД: " . $mysqli->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $mysqli->prepare("DELETE FROM OrderDetails WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    header("Location: lab6.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_name = $_POST['product_name'];
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $order_date = $_POST['order_date'];

    if (!empty($product_name) && $quantity > 0 && $price > 0 && !empty($order_date)) {
        $stmt = $mysqli->prepare("INSERT INTO OrderDetails (product_name, quantity, price, order_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $product_name, $quantity, $price, $order_date);
        $stmt->execute();

        header("Location: lab6.php");
        exit;
    }
}

$filter_date = $_GET['date'] ?? '';
$query = "SELECT * FROM OrderDetails";
if (!empty($filter_date)) {
    $query .= " WHERE order_date = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $filter_date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $mysqli->query($query);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>lab6 - Замовлення</title>
</head>
<body>
    <h2>➕ Додати замовлення</h2>
    <form method="POST" action="lab6.php">
        <label>Назва продукту:</label>
        <input type="text" name="product_name" required><br><br>

        <label>Кількість:</label>
        <input type="number" name="quantity" min="1" required><br><br>

        <label>Ціна (грн):</label>
        <input type="number" step="0.01" name="price" min="0.01" required><br><br>

        <label>Дата замовлення:</label>
        <input type="date" name="order_date" required><br><br>

        <button type="submit">Додати</button>
    </form>

    <hr>

    <h2>📋 Список замовлень</h2>

    <form method="GET" action="lab6.php">
        <label>Фільтр за датою:</label>
        <input type="date" name="date" value="<?= htmlspecialchars($filter_date) ?>">
        <button type="submit">Фільтрувати</button>
        <a href="lab6.php"><button type="button">Скинути фільтр</button></a>
    </form>

    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Продукт</th>
            <th>Кількість</th>
            <th>Ціна</th>
            <th>Дата</th>
            <th>Дії</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['order_date'] ?></td>
            <td>
                <a href="lab6.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?')">Видалити</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
