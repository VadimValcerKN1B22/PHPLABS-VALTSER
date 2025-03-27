<?php
if (isset($_POST['number'])) {
    $number = $_POST['number'];
    $result = ($number > 10) ? "Число $number більше за 10" : "Число $number не більше за 10";
    echo $result;
}
?>

<form method="post">
    Введіть число: <input type="number" name="number">
    <button type="submit">Перевірити</button>
</form>