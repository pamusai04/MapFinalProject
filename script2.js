// Initialize the map
var map = L.map('map').setView([22.9074872, 79.07306671], 7); // Set initial view based on your region

// Add OpenStreetMap tile layer
var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Array to keep track of current markers
var currentMarkers = [];

// Function to clear markers from the map
function clearMarkers() {
    currentMarkers.forEach(function(marker) {
        map.removeLayer(marker);
    });
    currentMarkers = []; // Reset the marker array
}

// Generic function to fetch and display markers
function showMarkers(url, popupContentFn) {
    clearMarkers(); // Clear previous markers
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            data.forEach(function(item) {
                if (item.latitude && item.longitude) {
                    var marker = L.marker([parseFloat(item.latitude), parseFloat(item.longitude)]).addTo(map);
                    marker.bindPopup(popupContentFn(item)); // Bind the popup content
                    currentMarkers.push(marker); // Store marker
                } else {
                    console.error('Invalid lat/lng for item:', item);
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Popup content for each type of marker
function bankPopupContent(bank) {
    return `
        <strong>${bank.name}</strong><br>
        Branch: ${bank.branch}<br>
        Email: ${bank.email}<br>
        Working Hours: ${bank.working_hours}
    `;
}

function collegePopupContent(college) {
    return `
        <strong>${college.name}</strong><br>
        Location: ${college.location}<br>
        Contact Number: ${college.contact_number}<br>
        Email: ${college.email}<br>
    `;
}

function schoolPopupContent(school) {
    return `
        <strong>${school.name}</strong><br>
        Location: ${school.location}<br>
        Contact Number: ${school.contact_number}<br>
        Email: ${school.email}<br>
    `;
}

function hospitalPopupContent(hospital) {
    return `
        <strong>${hospital.name}</strong><br>
        Location: ${hospital.location}<br>
        Email: ${hospital.email}<br>
        Treatments: ${hospital.types_of_treatments}<br>
        Visiting Hours: ${hospital.visiting_hours}
    `;
}

function templePopupContent(temple) {
    return `
        <strong>${temple.name}</strong><br>
        Location: ${temple.location}<br>
        Email: ${temple.email}<br>
        Address: ${temple.address}
    `;
}

// Event listeners for displaying different types of markers
document.querySelector("#bankquery").addEventListener("click", function(event) {
    event.preventDefault();
    showMarkers('./showBanks.php', bankPopupContent);
});

document.querySelector("#colleges").addEventListener("click", function(event) {
    event.preventDefault();
    showMarkers('./showColleges.php', collegePopupContent);
});

document.querySelector("#schools").addEventListener("click", function(event) {
    event.preventDefault();
    showMarkers('./showSchools.php', schoolPopupContent);
});

document.querySelector("#hospitals").addEventListener("click", function(event) { 
    event.preventDefault();
    showMarkers('./showHospital.php', hospitalPopupContent);
});

document.querySelector("#templequery").addEventListener("click", function(event) {
    event.preventDefault();
    showMarkers('./showTemples.php', templePopupContent);
});
