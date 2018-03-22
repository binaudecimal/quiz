<?php

?>

<div class='container-fluid pt-5 h-100' style='background-color:#eee;'>
    <div class='card mt-5 pt-5'>
        <div class='card-content'>
            <div class='card-header'>
                <h3 class='card-title'>Database Initialization</h3>
            </div>
            <div class='card-body'>
                <form class='form-group' id='db-setup-form' action='db-form-submit' method='POST'>
                    <p class='lead'>
                        You are seeing this because there is no database found. This is the primary setup page where the database will be initialized, as well as the administrator account as inputted below.
                    </p>
                    <label for='#admin-first'>Admin Firstname: </label>
                    <input class='form-control' type='text' placeholder='Admin Firstname' name='first' id='admin-first' autofocus='auto' required>
                    <label for='#admin-last'>Admin Lastname: </label>
                    <input class='form-control' type='text' placeholder='Admin Lastname' name='last' id='admin-last' required>
                    <label for='#admin-username'>Admin Username: </label>
                    <input class='form-control' type='text' placeholder='Admin Username' name='username' id='admin-username' required>
                    <label for='#admin-password'>Admin Password: </label>
                    <input class='form-control' type='password' placeholder='Admin Password' name='password' id='admin-password' required>
                    <span class='pt-3'>
                        <button class='btn btn-primary' type='submit'>SUBMIT</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
