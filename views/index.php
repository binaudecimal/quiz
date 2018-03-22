<?php
    if(UserController::dbExist()){
        header('Location: home');
        exit();
    }
    $image = floor(rand(1,6));
?>
<div class='background-image'>

</div>
