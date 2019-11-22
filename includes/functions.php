<?php
function uikar_ukpostalcode_main()
{
//    $postalCodeURL = 'https://api.postcodes.io/postcodes/';
//    $method = 'GET';
    $postacode = $_GET['uikarPostalcode'];
    uikar_ukpostalcode_submitform($postacode);
    if($postacode)
    {
        uikar_ukpostalcode_map_plot($postacode);
    }
}

function uikar_ukpostalcode_submitform($postacode)
{
    require_once(UIKAR_POSTALCODE_BUILDER_DIR . 'includes/links.php');
    ?>
    <form method="GET" action="<?php echo ($_SERVER['REQUEST_URI']); ?>">
        <header class="product-shower--header clearfix">
            <h3><i class="far fa-chart-bar"></i><?php _e('Route to ', 'uikar-ukpostalcode'); echo(bloginfo('name'));?></h3>
        </header>
        <div class="uikar_ukpostalcode-wrapper clearfix">
            <input type="text" name="uikarPostalcode" value="<?php echo($postacode);?>" placeholder="<?php _e('Enter Your UK Postal code', 'uikar-ukpostalcode');?>" />
            <input type="submit" value="Route" />
        </div>
    </form>
    <?php
}

function uikar_ukpostalcode_map_plot($postacode)
{
    //$postalcode = $_GET['postalcode'];
    //&origin=41.43206,-81.38992&destination=35.7583719,51.3994681
    $googleMapAPIkey = get_option('googleMapAPI');
    if($googleMapAPIkey)
    {
        $apiKey = $googleMapAPIkey;
        $destinationLocation = get_option('destiantionLocation');?>
        <script type="text/javascript">
            function initMap() {
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom:7,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('panel'));
                var request = {
                    origin: '<?php echo($postacode);?>',
                    destination: '<?php echo($destinationLocation);?>',
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    }
                });
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo($apiKey);?>&callback=initMap"></script>
        <div class="content-page-wrapper contact-wrapper clearfix">
            <div id="map" class="map-maker clearfix" style="width:48%;height:500px;float:left">
            </div>
            <div id="panel" style="width: 48%; float: right;"></div>
        </div>
        <?php
    }
    else
    {?>
        <p><?php _e('You Must Have Google API key', 'uikar-ukpostalcode');?></p>
    <?php
    }
}

function uikar_ukpostalcode_callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){
        ?>
        <p><?php _e('Connection Failure', 'uikar-ukpostalcode')?></p>
        <?php
    }
    curl_close($curl);
    return $result;
}

