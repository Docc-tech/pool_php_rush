<?php
<?php

session_start();


try {
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Error : ' . $e->getMessage();
}

        $_SESSION['search_engine'] = $_POST['search_engine'].'%';
        $_SESSION['category_list'] = $_POST['category_list'];

if(isset($_POST['search_engine'])) {

    try {
        $reqSearch = $PDO->prepare("SELECT products.name AS productsName, products.price AS productsPrice FROM products INNER JOIN categories ON products.category_id = categories.id WHERE categories.parent_id=:CategorySelect AND products.name LIKE :searchQuery");
        $reqSearch->execute(['CategorySelect' => $searchSelect, 'searchQuery' => $searchQueryExtended]);
        while ($donnees = $reqSearch->fetch()) {
            $_SESSION['donnees'] = $donnees;
        }

        print_r($_SESSION['donnees']);
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }
}
?>

       // $_SESSION['search_engine'] = $_POST['search_engine'].'%';
        //$_SESSION['category_list'] = $_POST['category_list'];

        //header("Location: results.php");


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
        <button>Search</button>
    </div>
</form>

</body>
</html>
