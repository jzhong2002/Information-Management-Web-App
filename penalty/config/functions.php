<?php

require_once __DIR__ . '/../../config/db.php';
function display_data(){
    global $con;
    $query = "select * from penalty";
    $result = mysqli_query($con, $query);
return $result;
}
?>