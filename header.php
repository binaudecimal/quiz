<?php
    Controller::setSession();
?>

<html>
    <header>
        <title>Philippine Quiz Game</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <div class='container-fluid'>
                    <nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
					 <a class="navbar-brand" href="home">Home</a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class='nav-item'>
                                <a class='nav-link' href='student'>STUDENT</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' href='teacher'>TEACHER</a>
                            </li> 
                            <li class='nav-item'>
                                <a class='nav-link' href='admin'>ADMIN</a>
                            </li> 
                            <?php
                                if(!isset($_SESSION['username']) || !isset($_SESSION['session_id'])){
                                    echo "
                                        <form class='form-inline' action='login' method='POST'>
                                            <li class='nav-item'>
                                                <input class='form-control' type='text' placeholder='Username' name='username'>
                                            </li>
                                            <li class='nav-item'>
                                                <input class='form-control' type='password' placeholder='Password' name='password'>
                                            </li>
                                            <li class='nav-item'>
                                                <button class='btn btn-light' role='submit' type='submit' name='login-submit'>LOGIN</button>
                                            </li>
                                        </form>
                                    ";
                                }
                            else{
                                echo "
                                    <li class='nav-item'>
                                        <a class='btn btn-light' role='button' name='logout-submit' href='logout'>LOGOUT</a>
                                    </li>
                                ";
                            }
                            ?>
                            
                        </ul>
                    </div>
			     </nav>
            </div>
    </header>
    
</html>