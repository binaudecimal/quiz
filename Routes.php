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
    Route::set('admin', function(){
        Controller::createView('admin-home');
    });
    Route::set('signup', function(){
        Controller::createView('signup');
    });
    Route::set('add-class', function(){
        SectionController::addClass();
    });
    Route::set('add-question', function(){
        Controller::createView('add-question');
    });
    Route::set('edit-question', function(){
        Controller::createView('edit-question');
    });
    Route::set('quiz-take', function(){
        QuestionController::startQuiz();
    });
    Route::set('signup-submit', function(){
        UserController::signup();
    });
    Route::set('login', function(){
        UserController::login();
    });
    Route::set('logout', function(){
        UserController::logout();
    });
    //Quizzes
    Route::set('getAllQuiz', function(){
        QuestionController::getAllQuiz();
    });
    Route::set('generate-quiz', function(){
        QuestionController::generateQuiz();
    });
?>
