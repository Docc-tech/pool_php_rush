<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>inscription</title>
</head>
<body>
<ul>
    <li>
        ID : <?php echo $_SESSION['id']?>
    </li>
    <li>
        Username :<?php echo $_SESSION['username']?>
    </li>
    <li>
        Email : <?php echo $_SESSION['email']?>
    </li>
    <li>
        Password : <?php echo $_SESSION['password']?>
    </li>
</ul>
<div>
    <a href="user.php">retour à user</a>
</div>

</form>
</body>
</html>
