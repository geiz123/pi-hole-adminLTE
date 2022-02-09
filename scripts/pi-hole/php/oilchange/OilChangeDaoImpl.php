<?php
require_once("scripts/pi-hole/php/database.php");

class OilChangeDaoImpl
{
  private $OILCHANGEDB = "/etc/pihole/oilchange.db";
  private $QRY_GETALLMAXMILEAGE = "SELECT OC.*
    FROM OIL_CHANGE OC
    INNER JOIN
    (SELECT
    MAKE, MODEL, MYEAR, COLOR, MAX(MILEAGE) AS MAX_MILEAGE
    FROM OIL_CHANGE
    GROUP BY MAKE, MODEL, MYEAR, COLOR) OC2
    ON OC2.MAKE = OC.MAKE
      AND OC2.MODEL = OC.MODEL
      AND OC2.MYEAR = OC.MYEAR
      AND OC2.COLOR = OC.COLOR
      AND OC2.MAX_MILEAGE = OC.MILEAGE";
  
  private $QRY_INSERTUPDATE = "INSERT OR REPLACE 
    INTO OIL_CHANGE(MAKE, MODEL, MYEAR, COLOR, MILEAGE, OIL_CHANGE_DT, DESCRIPTION)
    VALUES(:make, :model, :myear, :color, :mileage, :oil_change_dt, :description);";

  private $QRY_GETOILCHANGEBYID = "";

  public function getLastOilChange() {
    $ret = array();

    $db = SQLite3_connect($this->OILCHANGEDB);
    $results = $db->query($this->QRY_GETALLMAXMILEAGE);

    while ($results !==false && $res = $results->fetchArray(SQLITE3_ASSOC)) {
      array_push($ret, $res);
    }

    $results->finalize();
    
    return $ret;
  }

  /**
   * Insert / update oil change bean
   */
  public function saveOilChange($oilChange) {

    $db = SQLite3_connect($this->OILCHANGEDB, SQLITE3_OPEN_READWRITE);

    $stmt = $db->prepare($this->QRY_INSERTUPDATE);
    if (!$stmt) {
      throw new Exception('While preparing statement: ' . $db->lastErrorMsg());
    }

    if (!$stmt->bindValue(':make', $oilChange->getMake(), SQLITE3_TEXT)) {
      throw new Exception('While binding car maker: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':model', $oilChange->getModel(), SQLITE3_TEXT)) {
      throw new Exception('While binding car model: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':myear', $oilChange->getMyear(), SQLITE3_INTEGER)) {
      throw new Exception('While binding car myear: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':color', $oilChange->getColor(), SQLITE3_TEXT)) {
      throw new Exception('While binding car color: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':mileage', $oilChange->getMileage(), SQLITE3_INTEGER)) {
      throw new Exception('While binding car mileage: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':oil_change_dt', $oilChange->getOil_change_dt(), SQLITE3_TEXT)) {
      throw new Exception('While binding car oil_change_dt: <strong>' . $db->lastErrorMsg() . '</strong>');
    }
    if (!$stmt->bindValue(':description', $oilChange->getDescription(), SQLITE3_TEXT)) {
      throw new Exception('While binding car description: <strong>' . $db->lastErrorMsg() . '</strong>');
    }

    if (!$stmt->execute()) {
      throw new Exception('While executing: <strong>' . $db->lastErrorMsg() . '</strong><br>');
    }

    return 1;
  }
}

?>