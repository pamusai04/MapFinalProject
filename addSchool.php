<?php  
include("./connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_number = filter_input(INPUT_POST, "contact_number", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $latitude = filter_input(INPUT_POST, "latitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, "longitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS); // Sanitize location input

    // Initialize an array to store error messages
    $errors = [];

    // Validate school name (should not be empty and should contain only letters and spaces)
    if (empty($name)) {
        $errors[] = "Please enter the school name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "School name should contain only letters and spaces.";
    }
    // Validate location (should not be empty)
    if (empty($location)) {
        $errors[] = "Please enter the location.";
    }

    // Validate contact number (should contain only digits and be of a reasonable length)
    if (empty($contact_number)) {
        $errors[] = "Please enter the contact number.";
    } elseif (!preg_match("/^\d{10}$/", $contact_number)) {
        $errors[] = "Contact number should be a valid 10-digit number.";
    }

    // Validate email address
    if (empty($email)) {
        $errors[] = "Please enter the email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate latitude (should be a valid float number between -90 and 90)
    if (empty($latitude)) {
        $errors[] = "Please enter the latitude.";
    } elseif (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors[] = "Latitude should be a number between -90 and 90.";
    }

    // Validate longitude (should be a valid float number between -180 and 180)
    if (empty($longitude)) {
        $errors[] = "Please enter the longitude.";
    } elseif (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors[] = "Longitude should be a number between -180 and 180.";
    }

    

    // If there are no errors, proceed with the database insertion
    if (empty($errors)) {
        // Check if the school location already exists
        $sql_q = "SELECT * FROM schools WHERE name = '$name' AND latitude = '$latitude' AND longitude = '$longitude'";
        $result = mysqli_query($conn, $sql_q);

        if (mysqli_num_rows($result) > 0) {
            // Update existing record
            echo '<div class="message">Bank location already exists!</div>';
        } else {
            // Insert new school location into the database
            $sql = "INSERT INTO schools (name, contact_number, email, latitude, longitude, location) 
                    VALUES ('$name', '$contact_number', '$email', '$latitude', '$longitude', '$location')";
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
?>