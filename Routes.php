<?php
	Route::set('', function(){
        header('Location: home');
        exit();
    });
    Route::set('home', function(){
    Controller::createView('index');
    });
    Route::set('student', function(){
        Controller::createView('student-home');
    });
    Route::set('teacher', function(){
        Controller::createView('teacher-home');
    });
    Route::set('signup', function(){
        Controller::createView('signup');
    });
    Route::set('add-question', function(){
        Controller::createView('add-question');
    });
    Route::set('edit-question', function(){
        Controller::createView('edit-question');
    });
    Route::set('quiz-take', function(){
        Controller::createView('quiz-take');
    });
?>
