<?php
// Include database connection
include('includes/conn.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $age = intval($_POST['age']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $gender = $_POST['gender'];
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $security_question = $_POST['security_question'];
    $security_answer = mysqli_real_escape_string($con, $_POST['security_answer']);

    // Encrypt the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists. Please try logging in.');</script>";
    } else {
        // Insert user into the database
        $query = "INSERT INTO users (name, email, password, age, address, gender, phone, security_question, security_answer) VALUES ('$name', '$email', '$hashed_password', $age, '$address', '$gender', '$phone', '$security_question', '$security_answer')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error: Unable to register. Please try again later.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
    </head>
    <body>
        <form method="POST" action="register.php">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email Address" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="number" name="age" placeholder="Age" required><br>
            <input type="text" name="address" placeholder="Address" required><br>
            <label>Gender:</label>
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female" required> Female<br>
            <input type="text" name="phone" placeholder="Phone Number" required><br>
            <select name="security_question" required>
                <option value="">Choose a security question</option>
                <option value="What is your first pet's name?">What is your first pet's name?</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            </select><br>
            <input type="text" name="security_answer" placeholder="Your Answer" required><br>
            <button type="submit">Register</button>
        </form>
    </body>
</html>