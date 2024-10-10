<?php

function generate_mdp()
{
    $string = "abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!:@&$-ù";
    $mdp= "";

    $mdp .=  $string[rand(0,25)];
    $mdp .=  $string[rand(0,25)];

    $mdp .=  $string[rand(26,51)];
    $mdp .=  $string[rand(26,51)];

    $mdp .=  $string[rand(52,61)];
    $mdp .=  $string[rand(52,61)];

    $mdp .=  $string[rand(62,68)];
    $mdp .=  $string[rand(62,68)];

    $mdp = str_shuffle($mdp);
    
    return $mdp;
}

function connection_bdd($db_name,$user,$mdp)
{
   try {
        $bdd = new PDO("mysql:host=localhost;dbname=$db_name;charset=utf8", "$user","$mdp");
   }

    catch (Exception $e){
        die('<b>Erreur</b> : ' . $e->getMessage());
    }
}

function logout() {

    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
}

function login() {

    
}

function input(){
    
}
?>