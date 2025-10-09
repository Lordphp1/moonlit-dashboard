<?php
include "./../../../includes/session.php";

header("Content-Type: application/json");

$action = $_POST['action'] ?? '';

switch ($action) {

    case "add_booking":
        $car_type_id    = intval($_POST['car_type_id']);
        $product_id     = intval($_POST['product_id']);
        $frontend_price = floatval($_POST['price']); // frontend price (for reference)
        $location_type  = trim($_POST['location_type']);
        $customer_name  = trim($_POST['customer_name']);
        $customer_email = trim($_POST['customer_email']);
        $customer_phone = trim($_POST['customer_phone']);
        $customer_addr  = $_POST['customer_address'] ?? null;
        $washing_date   = $_POST['washing_date'];
        $payment_method = $_POST['payment_method'];
        $payment_status = $_POST['payment_status'] ?? "pending";

        // ✅ Validation
        if (empty($car_type_id) || empty($product_id) || empty($customer_name) || empty($washing_date)) {
            echo json_encode(["status" => "error", "message" => "Please fill all required fields"]);
            exit;
        }

        // ✅ Securely fetch price from DB (ignore frontend value)
        $verified_price = getProductPrice($conn, $car_type_id, $product_id);
        if ($verified_price <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid price for selected car type and product"]);
            exit;
        }

        // ✅ Add or update customer
        $checkQuery = $conn->prepare("SELECT id FROM customers WHERE email=? OR phone=? LIMIT 1");
        $checkQuery->bind_param("ss", $customer_email, $customer_phone);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
        $customer = $result->fetch_assoc();

        if ($customer) {
            $customer_id = $customer['id'];
            updateCustomer($conn, $customer_id, $customer_name, $customer_email, $customer_phone, $customer_addr);
        } else {
            addCustomer($conn, $customer_name, $customer_email, $customer_phone, $customer_addr);
            $customer_id = $conn->insert_id;
        }

        // ✅ Record booking
        if (addBooking($conn, $car_type_id, $product_id, $verified_price, $location_type, $customer_id, $washing_date, $payment_method, $payment_status)) {
            echo json_encode(["status" => "success", "message" => "Booking recorded successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to record booking"]);
        }
        break;

    case "update_booking":
        $id = intval($_POST['id']);
        $car_type_id = intval($_POST['car_type_id']);
        $product_id  = intval($_POST['product_id']);
        $washing_date  = $_POST['washing_date'];
        $location_type = trim($_POST['location_type']);
        $payment_method = $_POST['payment_method'];
        $payment_status = $_POST['payment_status'];

        // Verify updated price
        $verified_price = getProductPrice($conn, $car_type_id, $product_id);
        if ($verified_price <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid price for selected car type and product"]);
            exit;
        }

        if (updateBooking($conn, $id, $car_type_id, $product_id, $verified_price, $location_type, $washing_date, $payment_method, $payment_status)) {
            echo json_encode(["status" => "success", "message" => "Booking updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case "delete_booking":
        $id = intval($_POST['id']);
        if (deleteBooking($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Booking deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    case "fetch_booking":
        $id = intval($_POST['id']);
        $data = getBookingById($conn, $id);
        if ($data) {
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking not found"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
?>
