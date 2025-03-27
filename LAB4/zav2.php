<?php
function square($number) {
    return $number * $number;
}

$numbers = range(1, 5);

$squaredNumbers = array_map('square', $numbers);

echo "Початковий масив: " . implode(', ', $numbers) . "<br>";
echo "Квадрати чисел: " . implode(', ', $squaredNumbers);
?>