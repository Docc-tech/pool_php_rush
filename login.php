<?php
session_start();

    try{
        $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'jlgp', 'password');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <div class="container mt-44 p-3">
    <div class="container w-50 okbro border rounded bg-light">
    <form method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="Email" class="form-control bg-light" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entrer email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="Password" class="form-control bg-light" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" name="remember_me" for="exampleCheck1">Remember me</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="inscription.php">Pas encore inscrit ? Passez à l'action !</a>

    </form>
    </div>
    </div>

</body>
</html>
