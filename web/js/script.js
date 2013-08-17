var gih = document.getElementById("geoinfoholder");

function getLocation()
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        gih.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showLoader()
{
    var btnHolder = document.getElementById("paffen-btn");
    btnHolder.innerHTML = "ff laden";
}

function setCityName(city)
{
    var cityHolder = document.getElementById("paffen-city");
    cityHolder.innerHTML = city;
}

function codeLatLng(lat, lng) {
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0;b<results[0].address_components[i].types.length;b++) {
                        if (results[0].address_components[i].types[b] == "locality") {
                            //this is the object you are looking for
                            city= results[0].address_components[i];
                            break;
                        }
                    }
                }
                //city data
                setCityName(city.long_name);
            } else {
                alert("No results found");
            }
          } else {
            alert("Geocoder failed due to: " + status);
          }
    });
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

    codeLatLng(position.coords.latitude, position.coords.longitude);

    showLoader();
    $.get(ffpaffenConfig.baseUrl + '/paffen/' + position.coords.latitude + '/' + position.coords.longitude, function(data) {
        var btnHolder = document.getElementById("paffen-btn");
        if (data.ffpaffen) {
            btnHolder.innerHTML = 'JA, natuurlijk';
            $(btnHolder).removeClass('btn-inverse').addClass('btn-success');
        } else {
            btnHolder.innerHTML = 'Nee nu ff niet';
            $(btnHolder).removeClass('btn-success').addClass('btn-inverse');
        }
    });
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
$(document).ready(function() {
    getLocation();
    window.setInterval(getLocation, 5 * 60 * 1000);
});

