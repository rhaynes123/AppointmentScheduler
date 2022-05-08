<?php
require_once('Models/Appointment.php');
require_once('Data/Dbcontext.php');
class IndexController
{
    private $dbcontext;
    public function __construct()
    {
        $this->dbcontext = new Dbcontext();
    }
    public function LoadHomePage()
    {
        require_once('Views/home.php');
    }

    public function LoadMakeAppointmentPage()
    {
        require_once('Views/MakeAppointment.php');
    }

    public function LoadViewAppointmentsPage()
    {
        try
        {
            $title = "Appointments";
            $appointments = $this->dbcontext->GetAppointments();
            require_once('Views/ViewAppointments.php');
        }
        catch(PDOException $ex)
        {
            error_log($ex->getMessage());
            require_once('Views/error.php');
        }
        catch(Error $ex)
        {
            error_log($ex->getMessage());
            require_once('Views/error.php');
        }
    }
    
    
    public function SaveNewAppointment($appointmentPost)
    {
        try
        {
            $errors = Appointment::Validate();
            if(!empty($errors))
            {
                require_once('Views/MakeAppointment.php');
            }
            else
            {
                $appointment = new Appointment($appointmentPost);
                $this->dbcontext->CreateAppointment($appointment);
                $this->LoadViewAppointmentsPage();
            }
        }
        catch(PDOException $ex)
        {
            error_log($ex->getMessage());
            require_once('Views/error.php');
        }
        catch(Error $ex)
        {
            error_log($ex->getMessage());
            require_once('Views/error.php');
        }
        
    }
    
}