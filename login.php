<?php
session_start();

    try{
        $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e){
        echo 'Error : ' .$e->getMessage();
    }

    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $req = $PDO->prepare("SELECT password, username FROM users WHERE email=:Email");
    $req ->execute(['Email'=>$email]);
    $hash = $req->fetch();

    if(isset($_POST['Email']) && isset($_POST['Password']))
        if(preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['Email']) && password_verify($password, $hash['password'])){

            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['name'] = $hash['name'];
            if(isset($_POST['remember_me'])){
                setcookie('email', $email, time() + 365*24*3600, null, null, false, true);
                setcookie('password', $password, time() + 365*24*3600, null, null, false, true);
            }
            header("Location: index.php");
            exit();
        }
    else
        echo 'Incorrect email/password';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
</head>
<body>
    <form method="post">
        <input type="text" name="Email" placeholder="email"><br>
        <input type="password" name="Password" placeholder="password"><br>
        Remember me : <input type="checkbox" name="remember_me" value="remember_me"><br>
        <input type="submit" name="submit"><br>
        <a href="inscription.php">Pas encore inscrit ? Passez à l'action !</a>
    </form>
</body>
</html>
