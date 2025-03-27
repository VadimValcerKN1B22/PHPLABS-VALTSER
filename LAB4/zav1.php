<?php
$numbers = array();
for ($i = 0; $i < 10; $i++) {
    $numbers[] = rand(1, 100);
}

echo "Початковий масив: " . implode(', ', $numbers) . "<br>";

$filteredNumbers = array_filter($numbers, function($num) {
    return $num >= 50;
});

echo "Масив після видалення чисел менших за 50: " . implode(', ', $filteredNumbers);
?>