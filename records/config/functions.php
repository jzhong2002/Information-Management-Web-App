<?php

require_once __DIR__ . '/../../config/db.php';
function display_data(){
    global $con;
    $query = "select * from records";
    $result = mysqli_query($con, $query);
return $result;
}
?>