<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

// validate

$errors = [];

if (!Validator::email($email)){

    $errors['email'] = 'Please provide a valid email adress.';
}

if (!Validator::string($password,7,255)){

    $errors['password'] = 'Please provide a password of at least 7 characters.';
}

if(! empty($errors)){
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}


$db = App::resolve(Database::class);

$user = $db->query('select * from users where email = :email',[
    'email'=>$email
])->find();



//check if account already exists

//if yes, redirect to login page

if($user){

    header('location:/');
    exit();
} else {
    $db->query('INSERT INTO users(email, password) VALUES(:email,:password)', [
        'email' => $email,
        'password' => $password
    ] );


$_SESSION['user'] = [
    'email' => $email
];

header('location: /');
exit();

}

//else save one to database, log user in and redirect