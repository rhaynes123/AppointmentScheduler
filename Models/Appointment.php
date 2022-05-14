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
        $this->AppointmentNumber = uniqid(date("Ymd"));
        $this->Firstname = htmlspecialchars($post["Firstname"]);
        $this->Lastname = htmlspecialchars($post["Lastname"]);
        $this->Date = $post["AppointmentDate"];
        $this->EmailAddress = $post["EmailAddress"];
        $this->Notes = htmlspecialchars($post["Notes"]);
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
    public static function Validate()
    {
        $errors = [];
        $firstname = trim(htmlspecialchars($_POST['Firstname'],ENT_QUOTES, 'UTF-8'));
        if(strlen($firstname) <=0 || strlen($firstname) >= 100 || preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $firstname))
        {
            $errors['Firstname'] = "Firstname Invalid";
        }
        
        $lastname = trim(htmlspecialchars($_POST['Lastname'],ENT_QUOTES, 'UTF-8'));
        if(strlen($lastname) <=0 || strlen($lastname) >= 100 || preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $lastname))
        {
            $errors['Lastname'] = "Lastname Invalid";
        }

        $email = filter_input(INPUT_POST, 'EmailAddress', FILTER_SANITIZE_EMAIL);
        if($email && !filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['EmailAddress'] = "Email Invalid";
        }

        $date = htmlspecialchars($_POST['AppointmentDate'], ENT_QUOTES, 'UTF-8');
        if($date < date('Y-m-d'))
        {
            $errors['AppointmentDate'] = "Appointment Has To Be In the Future";
        }

        $notes = htmlspecialchars($_POST['Notes'], ENT_QUOTES, 'UTF-8');
        if(strlen($notes) >= 200 )
        {
            $errors['Notes'] = "Notes Has Too Many Characters";
        }

        foreach($errors as $key => $error)
        {
            error_log("value: $key Message: $error");
        }

        return $errors;
    }
}