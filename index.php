<?php
require_once("Controllers/IndexController.php");
$action = $_REQUEST['action'] ?? "";
$index = new IndexController();
switch($action)
{
    case 'requestAppointment':
        $index->LoadMakeAppointmentPage();
        break;
    case 'viewAppointments':
        $index->LoadViewAppointmentsPage();
        break;
    case 'saveAppointment':
        $index->SaveNewAppointment($_POST);
        break;
    default:
        $index->LoadHomePage();
    break;

}