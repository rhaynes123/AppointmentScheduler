# AppointmentScheduler
### Goal
The goal of this project is to produce a simple PHP project for learners to follow. It is targeted at beginner level programmer who know very little to know programming. 
It attempts to break down some far more advanced topics in a simple way to help guide beginners in building practical php web apps faster. To make the project practical we will be building an doctor appoint scheduling tool. 
###Concepts Introduced
1. Object Oriented PHP: Object oriented code is merely the practice of writing code files in Classes and classes are simply put code files meant to represent some real world concept.
This practice exists to help make the code we are writing easier to understand and better structured to represent some real world problem we are solving.
2. Model-View-Controller Pattern (MVC for short): MVC is a pattern that builds off object oriented code. This is simply a way to structure our project as a whole into 3 main parts. There can be more than the but there should be no less than these 3. Those 3 parts are
i. Models: These are classes that we intend to write to represent the data we want to save in our database.
ii. Controllers: These are classes that have the job of containing logic to send data to our models and then our database as well as the reverse and take data from our models and send to our user interface.
iii. Views: These are simply code files that house all the code that will make our user interface. Unlike Controllers and Models which will all be written in php these files may contain html,css, javascript and php. For this project we will only be using html,php and some css in the form of bootstrap.

### What you will need?
PHP:[How To Install PHP](https://kinsta.com/blog/install-php/)
SQLite Database: [How To Install SQLite](https://www.sqlitetutorial.net/download-install-sqlite/)
Visual Studio Code or some other IDE/Text editor: [How To Install Visual Studio Code](https://code.visualstudio.com/docs/setup/setup-overview)

#Step 1: Organize our folders
For this project we will need to create a few folders. First will be an AppointmentSchedule folder where all our subfolders and files will live. 
Once the folder exists next create an index.php file. It will should be the only file in this folder for now and for this project to work we can't move it. Next create the 3 folders we need to follow the MVC pattern so create a folder called Models another called Controllers and another called Views. The final folder we will need is a folder called Data. Programming languages have so many different tools and techniques for accessing our database that MVC doesn't even attempt to concern itself with that so its work that doesn't fall under one of the three main concepts.

#Step 2: Create Our Database
If you installed SQLite correctly you should have SQLite and hopefully you installed a tool to help work with sqlite. If you did create a file in the Data folder called app.db . This is a normal sqlite database file name. Open that database file in which tool you'd like and run the below sql script.
```SQL
-- SQLite
DROP TABLE IF EXISTS "Appointments";
CREATE TABLE "Appointments" (
    "Id" INTEGER NOT NULL CONSTRAINT "PK_Appointments" PRIMARY KEY AUTOINCREMENT,
    "AppointmentNumber" TEXT NOT NULL,
    "Firstname" TEXT NOT NULL,
    "Lastname" TEXT NOT NULL,
    "EmailAddress" TEXT NOT NULL,
    "AppointmentDate" TEXT NOT NULL,
    "Notes" TEXT NULL);
```
If there where no issues our database should now have an empty table called Appointments with 7 columns for the data we want to store. Next create a php file in the data folder called Dbcontext.php. Modify the file to look like the code below.
```php
<?php
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
```
The above file is doing a few things for us. The class will act as a representation our database to help keep our code organized. When the file is used it will open the app.db file and operate on the table we built. This class has 2 man functions, the GetAppointments and CreateAppointment. The GetAppointments function will get all the columns we've specified from our database for any appointments we save using the CreateAppointment. Keep in mind that for the CreateAppointment to properly save our data we need to make sure the column names and values line up correctly otherwise data may get inserted into the wrong columns.

Step 3. Creating our Model
Since our project is about appointments we are going to build and Appointment class. Go into our Models folder and make a file called Appointment.php
```php
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
```