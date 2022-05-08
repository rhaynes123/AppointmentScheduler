<?php
require_once('header.php');
require_once("Controllers/IndexController.php");
?>
<div class="text-center">
    <h1><?php echo $title ?></h1>
</div>
<div>
<table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Appointment Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($appointments) && !empty($appointments))
            {
                foreach($appointments as $appointment)
                {
                    ?>
                    <tr>
                        <td><?php echo $appointment["AppointmentNumber"] ?></td>
                        <td><?php echo $appointment["Firstname"] ?></td>
                        <td><?php echo $appointment["Lastname"] ?></td>
                        <td><?php echo $appointment["EmailAddress"] ?></td>
                        <td><?php echo $appointment["AppointmentDate"] ?></td>
                        <td><?php echo $appointment["Notes"] ?></td>
                    </tr>

                    <?php
                }

            }
            ?>
        </tbody>
    </table>
</div>