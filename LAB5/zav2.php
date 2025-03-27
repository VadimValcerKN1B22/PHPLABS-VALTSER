<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputDate = $_POST['date'] ?? '';
    
    if (empty($inputDate)) {
        $error = 'Будь ласка, введіть дату';
    } else {
        $dateParts = explode('-', $inputDate);
        
        if (count($dateParts) === 3) {
            $day = $dateParts[0];
            $month = $dateParts[1];
            $year = $dateParts[2];
            
            if (checkdate($month, $day, $year)) {
                $success = "Дата $inputDate є коректною!";
            } else {
                $error = "Дата $inputDate некоректна!";
            }
        } else {
            $error = "Невірний формат дати! Будь ласка, введіть дату у форматі ДД-ММ-РРРР";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перевірка дати</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .error { color: red; }
        .success { color: green; }
        form { margin-top: 20px; }
        input, button { padding: 8px; margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Перевірка коректності дати</h1>
    
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label for="date">Введіть дату (ДД-ММ-РРРР):</label><br>
        <input type="text" id="date" name="date" placeholder="наприклад: 25-12-2023" required
               pattern="\d{2}-\d{2}-\d{4}" title="Введіть дату у форматі ДД-ММ-РРРР">
        <button type="submit">Перевірити</button>
    </form>
</body>
</html>