<?php
require_once('header.php');
?>
<div class="text-center">
<h1>Make An Appointment</h1>
</div>
<div class="col-md-4">
<div class="card">
  <div class="card-body">
  <form method="POST" action="index.php?action=saveAppointment">
  <div class="mb-3">
        <label for="Firstname" class="form-label">First Name</label>
        <input type="text" class="form-control" id="Firstname" name="Firstname" required>
        </div>
        <div class="mb-3">
        <label for="Lastname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="Lastname" name="Lastname" required>
        </div>
        <div class="mb-3">
        <label for="EmailAddress" class="form-label">Email address</label>
        <input type="email" class="form-control" id="EmailAddress" name="EmailAddress"  placeholder="name@example.com" required>
        </div>
        <div class="mb-3">
        <label for="AppointmentDate" class="form-label">Appointment Date</label>
        <input type="date" class="form-control" id="AppointmentDate" name="AppointmentDate"required >
        </div>
        <div class="mb-3">
        <label for="Notes" class="form-label">Notes: </label>
        <textarea class="form-control" id="Notes" name="Notes" rows="3"></textarea>
        </div>
    <button type="submit" class="btn btn-primary">Submit Appointment</button>
    </form>
  </div>
</div>
</div>