<?php
class Appointment
{
    private $AppointmentNumber;
    private $Firstname;
    private $Lastname;
    private $EmailAddress;
    private $Date;
    private $Notes;

    public function __construct($post)
    {
        $data = array_map('htmlspecialchars', $post);// Santizing our data on construction 
       
        if(empty($data) || !isset($data["AppointmentDate"], $data["Firstname"], $data["Lastname"],$data["EmailAddress"]))// Making sure we got all the required stuff
        {
            die("One Or More Required Fields Were Not Provided!");
        }
        if($data["AppointmentDate"] < date('Y-m-d'))
        {
            die("Appointment Has To Be In the Future");
        }
        $this->AppointmentNumber = uniqid(date("Ymd"));
        $this->Firstname = $data["Firstname"];
        $this->Lastname = $data["Lastname"];
        $this->Date = $data["AppointmentDate"];
        $this->EmailAddress = $data["EmailAddress"];
        $this->Notes = $data["Notes"];
    }
    public function Number()
    {
        return $this->AppointmentNumber;
    }

    public function FirstName()
    {
        return $this->Firstname;
    }

    public function LastName()
    {
        return $this->Lastname;
    }

    public function Email()
    {
        return $this->EmailAddress;
    }

    public function GetDate()
    {
        return $this->Date;
    }

    public function Notes()
    {
        return $this->Notes;
    }
}