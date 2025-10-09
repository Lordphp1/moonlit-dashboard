<?php
include "./../../../includes/session.php";
header('Content-Type: application/json');

$carTypeId = intval($_POST['car_type_id'] ?? 0);
$productId = intval($_POST['product_id'] ?? 0);

if ($carTypeId > 0 && $productId > 0) {
    $stmt = $conn->prepare("SELECT price FROM product_prices WHERE car_type_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $carTypeId, $productId);
    $stmt->execute();
    $stmt->bind_result($price);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'success', 'price' => $price]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Price not found']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}
