<?php


$PDO= new PDO ("mysql:host=localhost;dbname=test;port=3306", docc, cucuagneau);

$req = $PDO->query("SELECT * FROM user");

while($donnees = $req->fetch()){
    echo $donnees['name'] .PHP_EOL;
}

