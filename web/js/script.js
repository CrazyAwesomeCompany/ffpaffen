var gih = document.getElementById("geoinfoholder");

function getLocation()
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        gih.innerHTML = "Geolocation is not supported by this browser.";
    }
}

//Property                  Description
//coords.latitude           The latitude as a decimal number
//coords.longitude          The longitude as a decimal number
//coords.accuracy           The accuracy of position
//coords.altitude           The altitude in meters above the mean sea level
//coords.altitudeAccuracy   The altitude accuracy of position
//coords.heading            The heading as degrees clockwise from North
//coords.speed              The speed in meters per second
//timestamp                 The date/time of the response
function showPosition(position)
{
    var latlon = position.coords.latitude + "," + position.coords.longitude;

    gih.innerHTML = "Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude;

    var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false";
    document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"' alt=''>";
}

function showError(error)
{
    switch(error.code) {
        case error.PERMISSION_DENIED:
            gih.innerHTML = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            gih.innerHTML = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            gih.innerHTML = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            gih.innerHTML = "An unknown error occurred.";
            break;
        default:
            break;
    }
}
// request user location
getLocation();
