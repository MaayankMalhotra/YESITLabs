<!DOCTYPE html>
<html lang="en">
<head>
    <title>Location</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=ADD_YOUR_GOOGLE_API_KEY_HERE&libraries=places">
</script>
</head>
<body>

    <h1>Api key is required for this part that was $200, but you can check the code</h1>

    <form action="">
        <label>To</label>
        <input type="text" id="to" required>
        <input type="text" placeholder="Latitude" id="lat_to">
        <input type="text" placeholder="Longitude" id="long_to">
        <br><br>
        <label>From</label>
        <input type="text" id="from" required>
        <input type="text" placeholder="Latitude" id="lat_from">
        <input type="text" placeholder="Longitude" id="long_from">
        <br>
<br>
        <input type="submit" value="Find Distance">

    </form>
    <div>
        <p class="data"></p>
    </div>

    <script type="text/javascript">
         $(document).ready(function(){
            
             var autocomplete_to, autocomplete_from;
             var to = 'to', from = 'from';

            //start for to google autocomplete with lat and long
             autocomplete_to = new google.maps.places.Autocomplete((document.getElementById(to)),{
                 types:['geocode'],
             })
             google.maps.event.addListener(autocomplete_to,'place_changed',function(){

                var place = autocomplete_to.getPlace();
                jQuery("#lat_to").val(place.geometry.location.lat());
                jQuery("#long_to").val(place.geometry.location.lng());

             })
            //end for to google autocomplete with lat and long

            //start for from google autocomplete with lat and long
             autocomplete_from = new google.maps.places.Autocomplete((document.getElementById(from)),{
                 types:['geocode'],
             })
             google.maps.event.addListener(autocomplete_from,'place_changed',function(){

                var place = autocomplete_from.getPlace();
                jQuery("#lat_from").val(place.geometry.location.lat());
                jQuery("#long_from").val(place.geometry.location.lng());

             })
             //end for from google autocomplete with lat and long


            //ajax to send data and get distance
            $("form").submit(function (event) {
                var lat_to = $("#lat_to").val();
                var long_to = $("#long_to").val();
                var lat_from = $("#lat_from").val();
                var long_from = $("#long_from").val();

                var req = new XMLHttpRequest();
                req.open("POST", "getDistance.php");
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                req.send("lat_to="+lat_to+"&long_to="+long_to+"&lat_from="+lat_from+"&long_from="+long_from);

                req.onreadystatechange = function(){
                    if(req.readyState == 4 && req.status == 200){
                       jQuery(".data").text(req.responseText);
                    }
                }

                event.preventDefault();
            });
         });
    </script>
    
</body>
</html>