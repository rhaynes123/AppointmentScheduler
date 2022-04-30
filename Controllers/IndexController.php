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
        $this->render('Views/home.php');
    }
    public function LoadViewAppointmentsPage()
    {
        try
        {
            $this->render('Views/ViewAppointments.php');
        }
        catch(PDOException $ex)
        {
            error_log($ex->getMessage());
            $this->render('Views/error.php');
        }
        catch(Error $ex)
        {
            error_log($ex->getMessage());
            $this->render('Views/error.php');
        }
    }
    public function LoadMakeAppointmentPage()
    {
        $this->render('Views/MakeAppointment.php');
    }
    public function GetAppointments()
    {
        return $this->dbcontext->GetAppointments();
    }
    public function SaveNewAppointment($appointmentPost)
    {
        try
        {
            $appointment = new Appointment($appointmentPost);
            $this->dbcontext->CreateAppointment($appointment);
            $this->render('Views/ViewAppointments.php');
        }
        catch(PDOException $ex)
        {
            error_log($ex->getMessage());
            $this->render('Views/error.php');
        }
        catch(Error $ex)
        {
            error_log($ex->getMessage());
            $this->render('Views/error.php');
        }
        
    }
    private function render($file) 
    {
        include $file;
    } 
}