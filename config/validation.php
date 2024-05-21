<?php
function ValidateLogin($username, $password){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT id FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        die("Error in execution: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    mysqli_close($conn);

    if ($row) {
        $user_id = $row['id'];
        header("location: ./public/user.php?user_id=$user_id");
        exit();
    } else {
        return false;
    }
}

function Register($username, $email, $password, $lrn, $section){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, lrn, section, type) VALUES (?, ?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $lrn, $section);
    if (!$stmt->execute()) {
        die("Error in execution: " . $stmt->error);
    }
    
    // Get the ID of the inserted user
    $user_id = $stmt->insert_id;

    // Close the statement
    $stmt->close();

    // Close the connection
    mysqli_close($conn);

    // Redirect to user.php after successful registration
    header("Location: ./public/user.php?user_id=$user_id");
    exit();
}