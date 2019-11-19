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
        Username : <?php echo $_SESSION['name']?>
    </li>
    <li>
        Email : <?php echo $_SESSION['price']?>
    </li>
</ul>
<div>
    <a href="items.php">retour à product</a>
</div>

</form>
</body>
</html>
