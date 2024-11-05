<?php 
include("./connection.php"); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Navbar with Leaflet Map</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <link rel="stylesheet" href="style.css">


</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar"> <!-- Updated to custom class -->
        <a class="navbar-brand" href="#">Map</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-initial="A">
                        Add Locations
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./bankForm.php">Add Bank</a>
                        <a class="dropdown-item" href="./templeForm.php" >Add Temple</a>
                        <a class="dropdown-item" href="./collegeForm.php">Add College</a>
                        <a class="dropdown-item" href="./schoolForm.php" >Add School</a>
                        <a class="dropdown-item" href="./hospitalForm.php">Add Hospital</a>

                    </div>

                </li>

                
                <li class="nav-item">
                    <a class="nav-link" href="./showMarker.html" id="bankquery" data-initial="B">Show Banks  <span class="sr-only">(current)</span></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="./showMarker.html" id="colleges" data-initial="C">Show Colleges</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./showMarker.html" id="schools" data-initial="S">Show Schools</a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" href="./showMarker.html" id="hospitals" data-initial="H">Show Hospitals</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="./showMarker.html" id="templequery" data-initial="T">Show Temples</a>
                </li>

            </ul>
            
        </div>
    </nav>
    <div id="map"></div>
    <div class="message" id="message"><?php echo $message; ?></div>

    <div class="parent">
        <div class="container">
            <h2 class="small-heading">Enter Hospital Location Details</h2>
            <form action="./addHospital.php" method="post">
                <div class="form_group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="types_of_treatments">Types of Treatments</label>
                    <input type="text" name="types_of_treatments" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="lat" required>
                </div>
                <div class="form_group">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="lng" required>
                </div>
                <div class="form_group">
                    <label for="visiting_hours">Visiting Hours</label>
                    <input type="text" name="visiting_hours" class="form-control" required>
                </div>
                <input type="submit" name="add_data" value="Add Data" class="btn">
            </form>

            
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="script.js"></script>

</body>
</html>
