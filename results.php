<?php

session_start();

//$result = $_SESSION['result'];

while ($donnees = $_SESSION['result']->fetch()) {
    echo $donnees['productsName'] .' ' .$donnees['productsPrice'] ." EUR " ."<br />";
}


/*
try {
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Error : ' . $e->getMessage();
}

if(isset($_POST['submit'])){

    try {

        $searchSelect = $_POST['search_engine'] .'%';
        $searchQueryExtended = $_POST['category_list'];

        $reqSearch = $PDO->prepare("SELECT products.name AS productsName, products.price AS productsPrice FROM products INNER JOIN categories ON products.category_id = categories.id WHERE categories.parent_id=:CategorySelect AND products.name LIKE :searchQuery");
        $reqSearch->execute(['CategorySelect' => $searchQueryExtended, 'searchQuery' => $searchSelect]);
        while ($donnees = $reqSearch->fetch()) {
            echo $donnees['productsName'] .' ' .$donnees['productsPrice'] ." EUR " ."<br />";
        }
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
        }
}*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>

<form action="" method="post">
    <div>
        <select name="category_list">
            <?php
            $reqSearchParentId = $PDO->query("SELECT DISTINCT parent_id FROM categories");
            while($data = $reqSearchParentId->fetch()){
                echo '<option name="Category_select">' .$data['parent_id'] .'</option>';
            }

            ?>
        </select>
        <input type="search" name="search_engine" placeholder="Search" maxlength="30">
        <input type="submit" name="submit">

    </div>
</form>

</body>
</html>