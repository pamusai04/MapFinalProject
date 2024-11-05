<?php
include("./connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_number = filter_input(INPUT_POST, "contact_number", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_input(INPUT_POST, "latitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, "longitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Initialize an array to store error messages
    $errors = [];

    // Validate required fields
    if (empty($name)) {
        $errors[] = "Please enter the college name.";
    }
    if (empty($location)) {
        $errors[] = "Please enter the location.";
    }
    if (empty($contact_number)) {
        $errors[] = "Please enter the contact number.";
    }
    if (empty($email)) {
        $errors[] = "Please enter the email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($latitude)) {
        $errors[] = "Please enter the latitude.";
    } elseif (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors[] = "Latitude should be a number between -90 and 90.";
    }
    if (empty($longitude)) {
        $errors[] = "Please enter the longitude.";
    } elseif (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors[] = "Longitude should be a number between -180 and 180.";
    }

    // If no errors, insert into the database
    if (empty($errors)) {
        $sql_q = "SELECT * FROM colleges WHERE name = '$name' AND latitude = '$latitude' AND longitude = '$longitude'";
        $result = mysqli_query($conn, $sql_q);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="message">College location already exists!</div>';
        } else {
            $sql = "INSERT INTO colleges (name, location, contact_number, email, address, latitude, longitude) 
                    VALUES ('$name', '$location', '$contact_number', '$email', '$address', '$latitude', '$longitude')";
            try {
                mysqli_query($conn, $sql);
                echo '<script>window.location.href="index.html";</script>';
                exit();
            } catch (mysqli_sql_exception $e) {
                echo '<div class="message">Error: Unable to add location. Please try again.</div>';
            }
        }
    } else {
        // Display errors if any
        foreach ($errors as $error) {
            echo '<div class="message">' . $error . '</div>';
        }
    }
}

mysqli_close($conn);
?>