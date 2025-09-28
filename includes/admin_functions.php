<?php
function getSiteInfo($conn) {
    $sql = "SELECT * FROM ".SITEINFO." ORDER BY id ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // no record found
    }
}


function loginAdmin($conn, $email, $password) {
    $sql = "SELECT * FROM ".ADMINS." WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // assuming password is hashed in DB
        if (password_verify($password, $admin['password'])) {
            return [
                "status" => "success",
                "message" => "Login successful",
                "admin" => $admin
            ];
        } else {
            return ["status" => "error", "message" => "Invalid password"];
        }
    }
    return ["status" => "error", "message" => "Admin not found"];
}

function getAdminInfo($conn) {
    session_start();

    if (isset($_SESSION['admin_id'])) {
        $adminId = $_SESSION['admin_id'];

        $sql = "SELECT * FROM ".ADMINS." WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $adminId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    return false; // not logged in or invalid session
}


?>
