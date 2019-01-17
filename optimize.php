<?php
/**
 * Created by PhpStorm.
 * User: kcb01
 * Date: 1/15/2019
 * Time: 7:59 PM
 */

$handle = fopen("drivers.csv", "r");

$fp = fopen('./input.csv', 'w');

$drivers = [];

$isHeader = true;

$minsalary = $_POST['minsalary'];
$maxsalary = $_POST['maxsalary'];
$lineups = $_POST['lineups'];

fputcsv($fp, [$minsalary, $maxsalary, $lineups]);

while($data = fgetcsv($handle, 1000, ",")) {
    if($isHeader) {
        $isHeader = false;
        continue;
    }
    $drivers[] = [
        "ID" => $data[0],
        "Name" => $data[1],
        "Salary" => $data[2],
        "Min" => $_POST['min' . $data[0]],
        "Max" => $_POST['max' . $data[0]],
        "Proj" => $_POST['proj' . $data[0]],
    ];

    fputcsv($fp, [$data[0], $data[1], $data[2], $_POST['min' . $data[0]], $_POST['max' . $data[0]], $_POST['proj' . $data[0]]]);
}


fclose($fp);

exec("python3.6 main.py");