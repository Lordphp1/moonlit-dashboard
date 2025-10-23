<?php
// BOOKING FUNCTIONS

function getProductPrice($conn, $car_type_id, $product_id) {
    $query = "SELECT price FROM product_prices WHERE car_type_id=? AND product_id=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $car_type_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return floatval($row['price']);
    }
    return 0;
}

function addBooking($conn, $car_type_id, $product_id, $price, $location_type, $customer_id, $washing_date, $payment_method,
 $payment_status,  $washing_time, $callout_fee,   $carInfo) {
    //callout_fee
       $booking_code = "INV-".rand(000000,999999)."-".rand(000000,999999);
    $query = "INSERT INTO bookings 
        (booking_id,car_type_id, product_id, price, location_type, customer_id, washing_date, payment_method, 
        payment_status, created_at, washing_time, callout_fee, car_info) 
        VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siidssssssss", $booking_code, $car_type_id, $product_id, $price, $location_type, $customer_id,
     $washing_date, $payment_method, $payment_status, $washing_time, $callout_fee,   $carInfo);
    return $stmt->execute();
}

function updateBooking($conn, $id, $car_type_id, $product_id, $price, $location_type, $washing_date, $payment_method, $payment_status) {
    $query = "UPDATE bookings 
              SET car_type_id=?, product_id=?, price=?, location_type=?, washing_date=?, payment_method=?, payment_status=?, updated_at=NOW() 
              WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iidssssi", $car_type_id, $product_id, $price, $location_type, $washing_date, $payment_method, $payment_status, $id);
    return $stmt->execute();
}

function deleteBooking($conn, $id) {
    $query = "DELETE FROM bookings WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}



function getAllBookings($conn) {
    $query = "
        SELECT 
            b.id,
            b.booking_id,
            b.car_type_id,
            ct.car_name AS car_type,
            b.product_id,
            p.product_name AS product_name,
            b.price,
            b.location_type,
            b.washing_date,
            b.washing_status,
            b.callout_fee,
            b.payment_method,
            b.payment_status,
            b.created_at,
            c.name AS customer_name,
            c.email AS customer_email,
            c.phone AS customer_phone,
            c.address AS customer_address
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.id
        LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
        LEFT JOIN products p ON b.product_id = p.id
        ORDER BY b.id DESC
    ";

    $result = $conn->query($query);
    $bookings = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    return $bookings;
}
function getBookingById($conn, $id) {
    $query = "
        SELECT 
            b.id,
            b.booking_id,
            b.car_type_id,
            ct.car_name AS car_type,
            b.product_id,
            p.product_name AS product_name,
            p.category_id,
            cat.category_name AS category_name,
            b.price,
            b.location_type,
            b.washing_date,
            b.car_info,
            b.payment_method,
            b.payment_status,
            b.washing_status,
            b.callout_fee,
            b.created_at,
            c.name AS customer_name,
            c.email AS customer_email,
            c.phone AS customer_phone,
            c.address AS customer_address
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.id
        LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
        LEFT JOIN products p ON b.product_id = p.id
        LEFT JOIN categories cat ON p.category_id = cat.category_id
        WHERE b.id = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null; // no booking found
}

function numberToWords($num) {
    $ones = [
        0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four",
        5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine",
        10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",
        14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen",
        17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen"
    ];

    $tens = [
        0 => "", 1 => "Ten", 2 => "Twenty", 3 => "Thirty", 4 => "Forty",
        5 => "Fifty", 6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
    ];

    $levels = ["", "Thousand", "Million", "Billion"];

    // Split number into whole and decimal parts
    $numParts = explode('.', number_format($num, 2, '.', ''));
    $whole = (int)$numParts[0];
    $decimal = (int)$numParts[1];

    // Function to convert 0–999
    $convertChunk = function ($n) use ($ones, $tens) {
        $words = "";
        $hundreds = floor($n / 100);
        $remainder = $n % 100;

        if ($hundreds) {
            $words .= $ones[$hundreds] . " Hundred";
            if ($remainder) $words .= " and ";
        }

        if ($remainder < 20 && $remainder > 0) {
            $words .= $ones[$remainder];
        } elseif ($remainder >= 20) {
            $words .= $tens[floor($remainder / 10)];
            if ($remainder % 10) {
                $words .= " " . $ones[$remainder % 10];
            }
        }

        return trim($words);
    };

    // Convert the whole number part
    $wholeWords = "";
    if ($whole === 0) {
        $wholeWords = "Zero";
    } else {
        $level = 0;
        while ($whole > 0) {
            $chunk = $whole % 1000;
            if ($chunk) {
                $chunkWords = $convertChunk($chunk);
                if ($levels[$level]) $chunkWords .= " " . $levels[$level];
                $wholeWords = trim($chunkWords . " " . $wholeWords);
            }
            $whole = floor($whole / 1000);
            $level++;
        }
    }

    // Convert decimal part (after the "point")
    $decimalWords = "";
    if ($decimal > 0) {
        $decimalWords = $convertChunk($decimal);
    }

    // Combine final result
    $result = $wholeWords;
    if ($decimalWords) {
        $result .= " point " . $decimalWords . " Cents";
    }

    return preg_replace('/\s+/', ' ', trim($result));
}


function getBookingStats($conn) {
    $today = date('Y-m-d');

    // Booking stats
    $query = "
        SELECT 
            COUNT(*) AS total_bookings,
            IFNULL(SUM(callout_fee), 0) AS total_callout_fee,
            IFNULL(SUM(price), 0) AS total_price,

            -- Pending wash (Paid but not completed)
            SUM(
                CASE 
                    WHEN payment_status = 'paid' 
                    AND washing_status = 'pending' 
                    THEN 1 ELSE 0 
                END
            ) AS total_pending,

            -- Today's pending washes (Paid but pending today)
            SUM(
                CASE 
                    WHEN payment_status = 'paid' 
                    AND washing_status = 'pending' 
                    AND washing_date = ? 
                    THEN 1 ELSE 0 
                END
            ) AS pending_today,

            -- Unpaid invoices
            SUM(CASE WHEN payment_status = 'unpaid' THEN 1 ELSE 0 END) AS total_unpaid,

            -- Paid transactions still in progress
            SUM(
                CASE 
                    WHEN payment_status = 'paid' 
                    AND washing_status = 'pending'
                    THEN 1 ELSE 0 
                END
            ) AS total_transactions
        FROM bookings
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();

    // Fetch total customers
    $customerQuery = "SELECT COUNT(*) AS total_customers FROM customers";
    $customerResult = $conn->query($customerQuery);
    $customers = $customerResult->fetch_assoc();

    // Fetch total products
    $productQuery = "SELECT COUNT(*) AS total_products FROM products";
    $productResult = $conn->query($productQuery);
    $products = $productResult->fetch_assoc();

    // Return all stats in one array
    return [
        'total_bookings'     => intval($stats['total_bookings']),
        'total_callout_fee'  => number_format((float)$stats['total_callout_fee'], 2, '.', ''),
        'total_price'        => number_format((float)$stats['total_price'], 2, '.', ''),
        'total_pending'      => intval($stats['total_pending']),
        'pending_today'      => intval($stats['pending_today']),
        'total_unpaid'       => intval($stats['total_unpaid']),
        'total_transactions' => intval($stats['total_transactions']),
        'total_customers'    => intval($customers['total_customers']),
        'total_products'     => intval($products['total_products'])
    ];
}

function getNextScheduledBooking($conn) {
    $query = "
        SELECT 
            b.id,
            b.booking_id,
            b.customer_id,
            b.washing_date,
            b.washing_time,
            CONCAT(
                LPAD(b.washing_time, 2, '0'),
                ':00 ',
                IF(b.washing_time >= 12, 'PM', 'AM')
            ) AS washing_time_formatted,
            b.location_type,
            b.price,
            b.callout_fee,
            b.payment_method,
            b.payment_status,
            b.washing_status,
            c.name AS customer_name,
            c.phone AS customer_phone,
            c.email AS customer_email,
            ct.car_name AS car_type,
            p.product_name AS product_name
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.id
        LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
        LEFT JOIN products p ON b.product_id = p.id
        WHERE 
            b.payment_status = 'paid'
            AND b.washing_status = 'pending'
        ORDER BY 
            STR_TO_DATE(CONCAT(b.washing_date, ' ', LPAD(b.washing_time, 2, '0')), '%Y-%m-%d %H') ASC
        LIMIT 1
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $nextBooking = $result->fetch_assoc();

    return $nextBooking ?: null;
}




?>
