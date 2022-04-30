<?php
require_once('Models/Appointment.php');
class Dbcontext extends SQLite3
{
    private $pdo;
    function __construct()
    {
        $this->open('Data/app.db');
        $this->pdo = new PDO('sqlite:Data/app.db');
    }

    public function GetAppointments()
    {
        $query = $this->pdo->query('SELECT AppointmentNumber, Firstname, Lastname, EmailAddress, AppointmentDate, Notes FROM Appointments');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function CreateAppointment($appointment)
    {
        $sql = 'INSERT INTO Appointments(AppointmentNumber,Firstname,Lastname,AppointmentDate,EmailAddress,Notes) 
        VALUES(:AppointmentNumber,:Firstname,:Lastname, :AppointmentDate,:EmailAddress,:Notes)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':AppointmentNumber' => $appointment->Number(),
            ':Firstname' => $appointment->FirstName(),
            ':Lastname' => $appointment->LastName(),
            ':EmailAddress' => $appointment->Email(),
            ':AppointmentDate' => $appointment->GetDate(),
            ':Notes' => $appointment->Notes(),
        ]);

        return $this->pdo->lastInsertId();
    }
}