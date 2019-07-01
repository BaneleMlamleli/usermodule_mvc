<?php
//20190614 - Created projectFunction.php - Banele
//20190615 - added a debug parameter  in print_rr function - Gael

    //20190614 - added a debug parameter  in print_rr function - Gael
    function print_rr($value, $debug=false){
        echo "<pre>";
        print_r($value, $debug);
        echo "</pre>";
    }
?>