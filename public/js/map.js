function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
    });
    const geocoder = new google.maps.Geocoder();
    geocodeAddress(geocoder, map);
}

function geocodeAddress(geocoder, resultsMap) {
    const address = document.getElementById("address").value;
    geocoder.geocode({ address: address }, (results, status) => {
        if (status === "OK") {
        resultsMap.setCenter(results[0].geometry.location);
        new google.maps.Marker({
            map: resultsMap,
            position: results[0].geometry.location,
        });
        } else {
        alert("エリア情報の取得に失敗しました。");
        }
    });
}

google.maps.event.addDomListener(window, 'load', initMap);