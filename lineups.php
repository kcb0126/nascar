<?php
/**
 * Created by PhpStorm.
 * User: kcb01
 * Date: 1/17/2019
 * Time: 10:39 PM
 */

require 'optimize.php';

$handle = fopen("output.csv", "r");

$response = [];

while($data = fgetcsv($handle, 1000, ",")) {
    $response[] = $data;
}

echo json_encode($response);