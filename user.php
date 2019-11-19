<?php
session_start();
try {
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Error : ' . $e->getMessage();
}

//creation User
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {
    if (strlen($_POST['name']) >= 3 && strlen($_POST['name']) <= 10) {
        if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email'])) {
            if (strlen($_POST['password']) >= 3 && strlen($_POST['password']) <= 10) {
                if ($_POST['password'] == $_POST['password_confirmation']) {
                    if (isset($_POST['submit'])) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $created_at = date('Y-m-d H:i:s ');

                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        try {
                            $req = $PDO->prepare('INSERT INTO users(username,password,email) VALUES (:name ,:hash, :email)');
                            $req->execute(['name' => $name, 'email' => $email, 'hash' => $hash]);
                        } catch (Exception $e) {
                            die('Error : ' . $e->getMessage());
                        }
                        echo 'User created';
                        $req->closeCursor();
                    }

                }
            } else
                echo 'Invalid password or password confirmation';

        } else
            echo 'Invalid email';
    } else
        echo 'Invalid name';
}
//Effacer user
if(isset($_POST['email_validation'])){
    if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email_validation'])) {
        if(isset($_POST['submit_suppr'])){

            $email_validation = $_POST['email_validation'];

            $reqEmailValidation = $PDO->prepare('DELETE FROM users WHERE email=:email_validation');
            $reqEmailValidation->execute(['email_validation' => $email_validation]);

            echo 'User Deleted';
                }
        }
    else
        echo 'Invalid email';
}
//éditer user
if(isset($_POST['email_edit_user'])){
    if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email_edit_user'])){
        if(isset($_POST['submit_edit_user'])){

            $emailExistUser = $_POST['email_edit_user'];

            $reqExistUser = $PDO -> prepare("SELECT * FROM users WHERE email=:emailExistUser");
            $reqExistUser->execute(['emailExistUser' => $emailExistUser]);
            $donnees = $reqExistUser->fetch();

            if($donnees){
                $_SESSION['username'] = $donnees['username'];
                $_SESSION['email'] = $donnees['email'];
                $_SESSION['password'] = $donnees['password'];
                $_SESSION['password_confirmation'] = $donnees['password'];
                $_SESSION['id'] = $donnees['id'];


                header("Location: edit_user.php");

            }
            else{
                echo 'Invalid Email';
            }


        }

    }


}
//infos user
if(isset($_POST['email_info_user'])) {
    if (preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email_info_user'])) {
        if (isset($_POST['submit_info_user'])) {

            $emailInfoUser = $_POST['email_info_user'];

            $reqInfoUser = $PDO->prepare("SELECT * FROM users WHERE email=:emailInfoUser");
            $reqInfoUser->execute(['emailInfoUser' => $emailInfoUser]);
            $donneesInfoUser = $reqInfoUser->fetch();

            if ($donneesInfoUser) {
                $_SESSION['username'] = $donneesInfoUser['username'];
                $_SESSION['email'] = $donneesInfoUser['email'];
                $_SESSION['password'] = $donneesInfoUser['password'];
                $_SESSION['password_confirmation'] = $donneesInfoUser['password'];
                $_SESSION['id'] = $donneesInfoUser['id'];


                header("Location: info_user.php");

            } else {
                echo 'Invalid Email';
            }


        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Modify Users</title>
</head>
<body>
<a href="admin.php">Retour vers Admin</a>
<h1>Creer un User</h1>
<form action="" method="post">
    <input type="text" name="name" placeholder="name"><br>
    <input type="text" name="email" placeholder="email"><br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="password" name="password_confirmation" placeholder="password_confirmation"><br><br>
    <input type="submit" name="submit" value="submit">
</form>

<h1>Effacer un User</h1>
<form action="" method="post">
    <input type="text" name="email_validation" placeholder="email"><br>
    <input type="submit" name="submit_suppr" value="submit">
</form>

<h1>Éditer un User</h1>
<form action="" method="post">
    <input type="text" name="email_edit_user" placeholder="email"><br>
    <input type="submit" name="submit_edit_user" value="submit">
</form>

<h1>Afficher infos User</h1>
<form action="" method="post">
    <input type="text" name="email_info_user" placeholder="email"><br>
    <input type="submit" name="submit_info_user" value="submit">
</form>
</body>
</html>