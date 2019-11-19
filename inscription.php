<?php
session_start();
try{
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e){
    echo 'Error : ' .$e->getMessage();
}


if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])){
    if(strlen($_POST['name']) >= 3 && strlen($_POST['name']) <= 10){
        if(preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",   $_POST['email']))
        {
            if(strlen($_POST['password']) >= 3 && strlen($_POST['password']) <= 10){
                if($_POST['password'] == $_POST['password_confirmation']){
                    if(isset($_POST['submit'])){
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $created_at = date('Y-m-d H:i:s ');

                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        try{
                            $req = $PDO->prepare('INSERT INTO users(username,password,email) VALUES (:name ,:hash, :email)');
                            $req->execute(['name' => $name, 'email' => $email, 'hash' => $hash]);
                        }
                        catch (Exception $e){
                            die('Error : ' .$e->getMessage());
                        }
                        echo 'User created';
                        $req -> closeCursor();
                    }

                }
            }
            else
                echo 'Invalid password or password confirmation';

        }
        else
            echo 'Invalid email';
    }
    else
        echo 'Invalid name';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>inscription</title>
</head>
<body>
<form action= "" method="post">
    <input type="text" name="name" placeholder="name" /*minlength="3" maxlength="10"*/><br>
    <input type="text" name="email" placeholder="email"><br>
    <input type="password"  name="password" placeholder="password"><br>
    <input type="password"  name="password_confirmation" placeholder="password_confirmation"><br><br>
    <input type="submit" name="submit" value="submit">
</form>
</body>
</html>
