<?php
session_start();
try {
    $PDO = new PDO("mysql:host=localhost;dbname=pool_php_rush;port=3306", 'docc', 'cucuagneau');
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Error : ' . $e->getMessage();
}

//creation produit
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['category_id'])) {
    if (strlen($_POST['name']) <= 50) {
        if ($_POST['price'] < 5000000000){
            $catId = $_POST['category_id'];
            $reqCategoryId = $PDO->prepare("SELECT * FROM categories WHERE id =:category_id ");
            $reqCategoryId->execute(['category_id' => $catId]);
            $donneeCategoryId = $reqCategoryId->fetch();
                if ($donneeCategoryId) {
                    if (isset($_POST['submit'])) {
                        $name = $_POST['name'];
                        $price = $_POST['price'];
                        $category_id = $_POST['category_id'];

                        try {
                            $req = $PDO->prepare('INSERT INTO products(name,price,category_id) VALUES (:name ,:price, :category_id)');
                            $req->execute(['name' => $name, 'price' => $price, 'category_id' => $category_id]);
                        } catch (Exception $e) {
                            die('Error : ' . $e->getMessage());
                        }
                        echo 'Product created';
                        $req->closeCursor();
                    }
            } else
                echo 'Invalid category';

        } else
            echo 'Invalid price';
    } else
        echo 'Invalid name';
}
//Effacer un produit
if(isset($_POST['name_suppr_produit'])){
    if (strlen($_POST['name_suppr_produit']) <= 50) {
        if(isset($_POST['submit_suppr'])){

            $name_suppr_produit = $_POST['name_suppr_produit'];

            $reqSupprProduit = $PDO->prepare('DELETE FROM products WHERE name=:name_suppr_produit');
            $reqSupprProduit->execute(['name_suppr_produit' => $name_suppr_produit]);

            echo 'Product Deleted';
        }
    }
    else
        echo 'Invalid product';
}
//éditer produit
if(isset($_POST['name_edit_product'])){
    if (strlen($_POST['name_edit_product']) <= 50){
        if(isset($_POST['submit_edit_product'])){

            $nameExistProduct = $_POST['name_edit_product'];

            $reqExistProduct = $PDO -> prepare("SELECT * FROM products WHERE name=:nameExistProduct");
            $reqExistProduct->execute(['nameExistProduct' => $nameExistProduct]);
            $donneesProduct = $reqExistProduct->fetch();

            if($donneesProduct){
                $_SESSION['name'] = $donneesProduct['name'];
                $_SESSION['price'] = $donneesProduct['price'];
                $_SESSION['category_id'] = $donneesProduct['category_id'];
                $_SESSION['id'] = $donneesProduct['id'];


                header("Location: edit_product.php");

            }
            else{
                echo 'Invalid name';
            }


        }

    }
    else{
        echo 'Invalid Email';
    }


}
//infos produit
if(isset($_POST['name_info_product'])) {
    if (strlen($_POST['name_info_product']) <= 50) {
        if (isset($_POST['submit_info_product'])) {

            $nameInfoProduct = $_POST['name_info_product'];

            $reqInfoProduct = $PDO->prepare("SELECT * FROM products WHERE name=:nameInfoProduct");
            $reqInfoProduct->execute(['nameInfoProduct' => $nameInfoProduct]);
            $donneesInfoProduct = $reqInfoProduct->fetch();

            if ($donneesInfoProduct) {
                $_SESSION['name'] = $donneesInfoProduct['name'];
                $_SESSION['price'] = $donneesInfoProduct['price'];
                $_SESSION['category_id'] = $donneesInfoProduct['category_id'];
                $_SESSION['id'] = $donneesInfoProduct['id'];


                header("Location: info_product.php");

            } else {
                echo 'Invalid Email';
            }


        }

    }
}
//creation categorie
if (isset($_POST['category_create_name'])){
        if ($_POST['submit_category_create']){

            $catIdCreateName = $_POST['category_create_name'];

            $reqCategoryCreate = $PDO->prepare("SELECT * FROM categories WHERE name =:catIdCreateName ");
            $reqCategoryCreate->execute(['catIdCreateName' => $catIdCreateName]);
            $donneeCategoryCreate = $reqCategoryCreate->fetch();
            if (!$donneeCategoryCreate) {
                    $categoryCreateName = $_POST['category_create_name'];
                    $categoryCreateParentId = $_POST['category_create_parent'];

                    try {
                        $reqCategoryInsert = $PDO->prepare("INSERT INTO categories(name,parent_id) VALUES (:name, :parent_id)");
                        $reqCategoryInsert->execute(['name' => $categoryCreateName, 'parent_id' => $categoryCreateParentId]);
                    } catch (Exception $e) {
                        die('Error : ' . $e->getMessage());
                    }
                    echo 'category created';

                    //header("Location: items.php");
                }else
                echo 'Category already exist';
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
<h1>Creer un Produit</h1>
<form action="" method="post">
    <input type="text" name="name" placeholder="name"><br>
    <input type="text" name="price" placeholder="price"><br>
    <input type="" name="category_id" placeholder="category_id"><br>
    <input type="submit" name="submit" value="submit">
</form>

<h1>Effacer un Produit</h1>
<form action="" method="post">
    <input type="text" name="name_suppr_produit" placeholder="name"><br>
    <input type="submit" name="submit_suppr" value="submit">
</form>

<h1>Éditer un Produit</h1>
<form action="" method="post">
    <input type="text" name="name_edit_product" placeholder="name"><br>
    <input type="submit" name="submit_edit_product" value="submit">
</form>

<h1>Afficher infos Produit</h1>
<form action="" method="post">
    <input type="text" name="name_info_product" placeholder="name"><br>
    <input type="submit" name="submit_info_product" value="submit">
</form>
<h1>Creation catégorie</h1>
<form action ="" method="post">
    <input type="text" name="category_create_name" placeholder="category_name"><br>
    <input type="text" name="category_create_parent" placeholder="category_parent"><br>
    <input type="submit" name="submit_category_create" value="submit">
</form>
</body>
</html>