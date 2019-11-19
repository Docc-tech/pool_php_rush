<?php
session_start();
try{
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e){
    echo 'Error : ' .$e->getMessage();
}

if(isset($_POST['name']) && isset($_POST['price']) && isset($_POST['category_id'])) {
    if (strlen($_POST['name']) < 50 && strlen($_POST['price']) < 500000000000) {
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $category_id = $_POST['category_id'];

                $idSearch = $_SESSION['id'];


                try {
                    $req = $PDO->prepare("UPDATE products SET name=:name, price=:price, category_id=:category_id WHERE id=:idSearch");
                    $req->execute(['name' => $name, 'price' => $price, 'category_id' => $category_id, 'idSearch' => $idSearch]);
                } catch (Exception $e) {
                    die('Error : ' . $e->getMessage());
                }

                header("Location: items.php");
            }

        } else
            echo 'Invalid name or price';

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
    <input type="text" name="name" placeholder="name" value="<?php echo $_SESSION['name']?>"><br>
    <input type="text" name="price" placeholder="price" value="<?php echo $_SESSION['price']?>"><br>
    <input type="text"  name="category_id" placeholder="category_id" value="<?php echo $_SESSION['category_id']?>"><br>
    <br>
    <input type="submit" name="submit" value="submit">
</form>
</body>
</html>
