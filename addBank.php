<?php 
include("./connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $branch = filter_input(INPUT_POST, "branch", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_number = filter_input(INPUT_POST, "contact_number", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $services = filter_input(INPUT_POST, "services", FILTER_SANITIZE_SPECIAL_CHARS);
    $working_hours = filter_input(INPUT_POST, "working_hours", FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_input(INPUT_POST, "latitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, "longitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $errors = [];

    if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Please enter a valid bank name.";
    }

    if (empty($branch) || !preg_match("/^[a-zA-Z\s]+$/", $branch)) {
        $errors[] = "Please enter a valid branch name.";
    }

    if (empty($contact_number) || !preg_match("/^\d{10}$/", $contact_number)) {
        $errors[] = "Contact number should be a 10-digit number.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($latitude) || !is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors[] = "Latitude should be a number between -90 and 90.";
    }

    if (empty($longitude) || !is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors[] = "Longitude should be a number between -180 and 180.";
    }

    if (empty($errors)) {
        $sql_q = "SELECT * FROM banks WHERE name = '$name' AND latitude = '$latitude' AND longitude = '$longitude'";
        $result = mysqli_query($conn, $sql_q);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="message">Bank location already exists!</div>';
        } else {
            $sql = "INSERT INTO banks (name, branch, contact_number, email, services, working_hours, latitude, longitude) 
                    VALUES ('$name', '$branch', '$contact_number', '$email', '$services', '$working_hours', '$latitude', '$longitude')";
                    
            try {
                mysqli_query($conn, $sql);
                echo '<script>window.location.href="index.html";</script>';
                exit();
            } catch (mysqli_sql_exception $e) {
                echo '<div class="message">Error: Unable to add location. Please try again.</div>';
            }
        }
    } else {
        foreach ($errors as $error) {
            echo '<div class="message">' . $error . '</div>';
        }
    }
}
?>
