<?php
include "./../../../includes/session.php";
$action = $_POST['action'] ?? '';

switch ($action) {
    case "fetch":
        $products = getProducts($conn);
        echo json_encode(["status" => "success", "data" => $products]);
        break;

    case "add":
        $name = trim($_POST['product_name']);
        $max_hours = trim($_POST['product_hours']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];

        if (empty($name) || empty($categoryId) || empty($max_hours)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        // 🕒 Convert hours (e.g. "2:30" → 150 mins)
        $maxMinutes = convertTimeToMinutes($max_hours);

        if (addProduct($conn, $categoryId, $name, $description, $prices, $maxMinutes, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Product added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add product"]);
        }
        exit;
        break;

    case "edit":
        $id = intval($_POST['product_id']);
        $name = trim($_POST['product_name']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];
        $max_hours = trim($_POST['product_hours']);

        // 🕒 Convert to minutes before saving
        $maxMinutes = convertTimeToMinutes($max_hours);

        if (updateProduct($conn, $id, $categoryId, $name, $description, $prices, $maxMinutes, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Product updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        exit;
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteProduct($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Product deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        exit;
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        exit;
}

// 🔹 Helper: Convert time input like "2:30" → 150 minutes
function convertTimeToMinutes($timeStr) {
    if (strpos($timeStr, ':') !== false) {
        list($h, $m) = array_map('intval', explode(':', $timeStr));
        return $h * 60 + $m;
    }
    return intval($timeStr) * 60; // e.g. "2" → 120
}

// 🔹 Optional helper: Convert minutes → readable format (for display/fetch)
function minutesToTimeFormat($minutes) {
    $h = floor($minutes / 60);
    $m = $minutes % 60;
    return sprintf("%d:%02d", $h, $m);
}
