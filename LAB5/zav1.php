<?php
if (isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['num3'])) {
    // Отримуємо значення з форми
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
    $num3 = $_GET['num3'];
    
    $average = ($num1 + $num2 + $num3) / 3;
    
    echo "<h3>Результат:</h3>";
    echo "Ви ввели числа: $num1, $num2, $num3<br>";
    echo "Середнє арифметичне: " . round($average, 2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Обчислення середнього арифметичного</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Введіть три числа</h2>
    <form method="GET" action="">
        <label for="num1">Число 1:</label>
        <input type="number" name="num1" id="num1" required><br><br>
        
        <label for="num2">Число 2:</label>
        <input type="number" name="num2" id="num2" required><br><br>
        
        <label for="num3">Число 3:</label>
        <input type="number" name="num3" id="num3" required><br><br>
        
        <input type="submit" value="Обчислити">
    </form>
</body>
</html>