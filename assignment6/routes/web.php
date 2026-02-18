<?php

use Illuminate\Support\Facades\Route;


Route::get('/student/{id}/{name?}', function ($id, $name = "Student") {

    return view('student.profile', [
        'studentId' => $id,
        'studentName' => $name
    ]);

});


Route::get('/course/{course}/{year?}', function ($course, $year = "1st Year") {

    return view('course.enrollment', [
        'courseName' => $course,
        'yearLevel' => $year
    ]);

});




Route::get('/ojt/{company}/{city}/{allowance?}', function ($company, $city, $allowance = "No Money") {

    return view('ojt.company', [
        'companyName' => $company,
        'cityName' => $city,
        'allowanceStatus' => $allowance
    ]);

});


Route::get('/event/{event}/{participant}/{year}', function ($event, $participant, $year) {

    return view('event.registration', [
        'eventName' => $event,
        'participantName' => $participant,
        'yearLevel' => $year
    ]);

});