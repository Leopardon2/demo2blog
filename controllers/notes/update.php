<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db=App::resolve(Database::class);


$currentUserId = 1;

// find note


    $note = $db->query('select * from notes where id = :id', [
        'id' => $_POST['id']
    ])->findOrFail();






// authorize user

authorize($note['user_id']=== $currentUserId);


//validate form

$errors = [];


if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}


//if no error, update record in database

if(count($errors)){
    return view('notes/edit.view.php', [
        'heading' => 'Edit Note',
        'errors'=> $errors,
        'note'=>$note
    ]);
}


$db->query('update notes set body = :body where id=:id', [
    'id'=>$_POST['id'],
    'body'=>$_POST['body']
]);

//redirect user

header('location: /notes');
die();