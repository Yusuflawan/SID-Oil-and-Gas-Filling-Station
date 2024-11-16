<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';

$db_conn = new Database();
$db = $db_conn->connect();
$admin = new Admin($db);

// Read JSON data from the request body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Check if the 'id' key is present in the decoded JSON
if (isset($data['id'])) {
    $inmateId = $data['id'];

    // Retrieve the inmate record
    $getInmateResponse = $admin->getInmateById($inmateId);

    if ($getInmateResponse['success']) {
        $inmateRecord = $getInmateResponse['data'];
        echo json_encode($inmateRecord); // Return the full inmate record as JSON
    } else {
        echo json_encode(['error' => $getInmateResponse['error']]); // Return the error message as JSON
    }
} else {
    echo json_encode(['error' => 'No ID provided']); // Handle missing ID in the request
}
?>
