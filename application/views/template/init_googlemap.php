<style>
    #map {
        height: 100%;
    }
</style>
<script>
    var map_markers = [];
    function initMap() {
        var mapCenter = {
            lat: <?php echo (isset($ongorulen_ders["DERS_ENLEM"]) && $ongorulen_ders["DERS_ENLEM"] !== "") ? $ongorulen_ders["DERS_ENLEM"]: "41.792161"; ?>, 
            lng: <?php echo (isset($ongorulen_ders["DERS_BOYLAM"]) && $ongorulen_ders["DERS_ENLEM"] !== "") ? $ongorulen_ders["DERS_BOYLAM"]: "27.162259"; ?>
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: mapCenter
        });
        map.addListener('click', function(e) {
            placeMarker(e.latLng, map);
        });
        var marker = new google.maps.Marker({
            position: mapCenter,
            map:map
        });
        map_markers.push(marker);
    }
        
    function placeMarker(latLng, map) {
        for(i=0; i<map_markers.length; i++){
            map_markers[i].setMap(null);
        }

        var marker = new google.maps.Marker({
            position: latLng,
            map:map
        });
        map_markers.push(marker);
        $("form").find("input[name=BOYLAM]").val(marker.position.lng);
        $("form").find("input[name=ENLEM]").val(marker.position.lat);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKnNUpzqZ16Ap1UJZznRbMgqFBkZ19TgQ&callback=initMap" async defer></script>