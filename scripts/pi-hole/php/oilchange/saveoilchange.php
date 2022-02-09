<?php

require_once("scripts/pi-hole/php/oilchange/OilChange.php");
require_once("scripts/pi-hole/php/oilchange/OilChangeDaoImpl.php");

$error = "";
$success = "";

// TODO something is wrong with this!!!!
function isEmpty($field) {
  if (isset($field["make"]) && strlen(trim($field["make"]))>0
    && isset($field["model"]) && strlen(trim($field["model"]))>0
    && isset($field["myear"]) && strlen(trim($field["myear"]))>0
    && isset($field["color"]) && strlen(trim($field["color"]))>0
    && isset($field["mileage"]) && strlen(trim($field["mileage"]))>0
    && isset($field["oil_change_dt"]) && strlen(trim($field["oil_change_dt"]))>0) {
    return false;
  } else {
    return true;
  }
}

if(isset($_POST["field"]))
{
  $insertCnt = 0;

  // Handle CSRF
  check_csrf(isset($_POST["token"]) ? $_POST["token"] : "");

  $oilChngDao = new OilChangeDaoImpl();
  $oilchange = null;

  foreach ($_POST["field"] as $field) {
    if (!isEmpty($field)) { 
      $oilchange = new OilChange($field["make"],$field["model"],
        $field["myear"],$field["color"],$field["mileage"],
        $field["oil_change_dt"],"");
      
      $insertCnt += $oilChngDao->saveOilChange($oilchange);
    }
  }

  unset($oilchange);
  unset($oilChngDao);

  $success = "Success! Inserted/Updated " . $insertCnt . " records.";
}
?>