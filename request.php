<?php

class People
{
  private $persons = array();
  
  function getPeople(){
        $row = 1;
        if (($handle = fopen("people.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {   
                $row++;
                $new_person =new Person($data);
                $this->persons[] = $new_person;
            }
            fclose($handle);
        } 
        //returning JSON array
        echo json_encode($this->persons);
  } 
}

class Person
{ 
  public $name;
  public $height;
  public $gender;
  public $birthday;
  function __construct($data) {
      $this->name = $data[0];
      $this->height = $data[1];
      $this->gender = $data[2];
      $this->birthday = $data[3];
  }
}
 
$people = new People();
$people->getPeople();

// Parse CSV
// Create a person for each record
// associate it to the higher class People
// return data back to index.php
//editted

?>
