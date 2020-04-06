<script src="{{url('js/admin/geocomplete/geocomplete.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIkVihJMqOvXqkdqzhugV5cX82DY3EPH0&v=3.exp&language=ar&amp;libraries=places"></script>

<script type="text/javascript">
$(document).ready(function () {
    var marker;
    var map;
    var lat;
    var lng;
    var pos = {lat: 24.718541641403505, lng: 46.66430937187499};
    
    var geocoder = new google.maps.Geocoder;
    map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 7,
        center: pos
    });
    $("#address").geocomplete({
    });
    $("#address").change(function () {
        if (marker) {
            marker.setMap(null);
        }
    });
    marker = new google.maps.Marker({
        draggable: true,
        position: pos,
        map: map
    });
    
    $("body").on('change', '#address', function () {
        var address = $(this).val();
        if (address != '') {
            geocoder.geocode({'address': address}, function (results, status) {
                if (status === 'OK') {
                    if (marker) {
                        marker.setMap(null);
                    }
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    var latlng = {lat: lat, lng: lng};
                    $("input[name=latitude]").val(lat);
                    $("input[name=longitude]").val(lng);
                    map.setCenter(new google.maps.LatLng(lat, lng));
                    map.setZoom(7);
                    marker = new google.maps.Marker({
                        draggable: true,
                        position: latlng,
                        map: map
                    });
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        $("input[name=latitude]").val(this.getPosition().lat());
                        $("input[name=longitude]").val(this.getPosition().lng());
                        latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                        geocoder.geocode({'location': latlng}, function (results, status) {
                            if (status === 'OK') {
                                if (results[1]) {
                                    $("#address").val(results[1].formatted_address);
                                }
                            }
                        });
                    });
                }
            });
        }
    });
    
 $("body").on('change', '#country_names', function () {
        var countryName = $("#country_names option:selected").val();
        var myarr = countryName.split("/");
        var address = myarr[1];
//        var address = $(this).val();
        if (address != '') {
            geocoder.geocode({'address': address}, function (results, status) {
                if (status === 'OK') {
                    if (marker) {
                        marker.setMap(null);
                    }
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    var latlng = {lat: lat, lng: lng};
                    $("input[name=latitude]").val(lat);
                    $("input[name=longitude]").val(lng);
                    latlng = {lat: lat, lng: lng};
                        geocoder.geocode({'location': latlng}, function (results, status) {
                            if (status === 'OK') {
                                if (results[1]) {
                                    $("#address").val(results[1].formatted_address);
                                }
                            }
                        });
                        
                    map.setCenter(new google.maps.LatLng(lat, lng));
                    map.setZoom(7);
                    marker = new google.maps.Marker({
                        draggable: true,
                        position: latlng,
                        map: map
                    });
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        $("input[name=latitude]").val(this.getPosition().lat());
                        $("input[name=longitude]").val(this.getPosition().lng());
                        latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                        geocoder.geocode({'location': latlng}, function (results, status) {
                            if (status === 'OK') {
                                if (results[1]) {
                                    $("#address").val(results[1].formatted_address);
                                }
                            }
                        });
                    });
                }
            });
        }
    });
    
    google.maps.event.addListener(marker, 'dragend', function (event) {
        $("input[name=latitude]").val(this.getPosition().lat());
        $("input[name=longitude]").val(this.getPosition().lng());
        latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
        geocoder.geocode({'location': latlng}, function (results, status) {
            if (status === 'OK') {
                if (results[1]) {
                    $("#address").val(results[1].formatted_address);
                }
            }
            map.setZoom(7);
        });
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (positions) {
            lat = positions.coords.latitude;
            lng = positions.coords.longitude;
            $("input[name=latitude]").val(lat);
            $("input[name=longitude]").val(lng);
            if (marker) {
                marker.setMap(null);
            }
            var latlng = {lat: lat, lng: lng};
            geocoder.geocode({'location': latlng}, function (results, status) {
                if (status === 'OK') {
                    if (results[1]) {
                        $("#address").val(results[1].formatted_address);
                        map.setCenter(new google.maps.LatLng(lat, lng));
                        marker = new google.maps.Marker({
                            draggable: true,
                            position: latlng,
                            map: map
                        });
                        map.setZoom(10);
                        google.maps.event.addListener(marker, 'dragend', function (event) {
                            $("input[name=latitude]").val(this.getPosition().lat());
                            $("input[name=longitude]").val(this.getPosition().lng());
                            latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                            geocoder.geocode({'location': latlng}, function (results, status) {
                                if (status === 'OK') {
                                    if (results[1]) {
                                        $("#address").val(results[1].formatted_address);
                                    }
                                }
                            });
                        });
                    }
                }
            });
        });
    }
});
</script>