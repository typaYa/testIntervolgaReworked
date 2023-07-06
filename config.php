<?php
$path = "C:\\sqlite\\main.db";

$queryCreate = "CREATE TABLE reviews(
        id int PRIMARY KEY,
        text TEXT,
        add_date DATE  
)";
$validUsers = [
    'user1'=>'password1'
];