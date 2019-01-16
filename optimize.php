<?php
/**
 * Created by PhpStorm.
 * User: kcb01
 * Date: 1/15/2019
 * Time: 7:59 PM
 */

$handle = fopen("drivers.csv", "r");

$drivers = [];

$isHeader = true;

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
        "Fave" => array_key_exists('fave' . $data[0], $_POST),
    ];
    $notused = 0;
}

$minsalary = $_POST['minsalary'];
$maxsalary = $_POST['maxsalary'];
$lineups = $_POST['lineups'];

$results = [];

$fp = fopen('./results/result.csv', 'w');

while(count($results) < $lineups) {
    $driver_ids = [];
    $driver_ids[] = rand(0, count($drivers) - 1);
    $driver_ids[] = rand(0, count($drivers) - 1);
    $driver_ids[] = rand(0, count($drivers) - 1);
    $driver_ids[] = rand(0, count($drivers) - 1);
    $driver_ids[] = rand(0, count($drivers) - 1);
    $driver_ids[] = rand(0, count($drivers) - 1);
    sort($driver_ids);
    $result = [];
    foreach($driver_ids as $driver_id) {
        $result[] = $drivers[$driver_id]["Name"];
    }

    $results[] = $result;

    fputcsv($fp, $result);

}

fclose($fp);

echo json_encode(["link" => "value"]);