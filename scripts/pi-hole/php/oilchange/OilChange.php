<?php

// OilChange POJO
class OilChange
{
	private $make;
  private $model;
	private $myear;
	private $color;
	private $mileage;
	private $oil_change_dt;
	private $description;
	private $updated_dt;

  function __construct($make,$model,$myear,$color,$mileage,$oil_change_dt,$description) {
    $this->make = strtoupper($make);
    $this->model = strtoupper($model);
    $this->myear = $myear;
    $this->color = strtoupper($color);
    $this->mileage = $mileage;
    $this->oil_change_dt = $oil_change_dt;
    $this->description = $description;
  }

	public function getMake(){
    return $this->make;
  }

  public function setMake($make){
    $this->make = strtoupper($make);
  }

  public function getModel(){
    return $this->model;
  }

  public function setModel($model){
    $this->model = strtoupper($model);
  }

  public function getMyear(){
    return $this->myear;
  }

  public function setMyear($myear){
    $this->myear = strtoupper($myear);
  }

  public function getColor(){
    return $this->color;
  }

  public function setColor($color){
    $this->color = strtoupper($color);
  }

  public function getMileage(){
    return $this->mileage;
  }

  public function setMileage($mileage){
    $this->mileage = strtoupper($mileage);
  }

  public function getOil_change_dt(){
    return $this->oil_change_dt;
  }

  public function setOil_change_dt($oil_change_dt){
    $this->oil_change_dt = $oil_change_dt;
  }

  public function getDescription(){
    return $this->description;
  }

  public function setDescription($description){
    $this->description = $description;
  }

  public function getUpdated_dt(){
    return $this->updated_dt;
  }

  public function setUpdated_dt($updated_dt){
    $this->updated_dt = $updated_dt;
  }
}

?>