<?php

include('config.php');

if(isset($_POST['update'])){
    $ID = $_POST['id'];
    $NAME  = $_POST['name'];
    $PRICE = $_POST['price'];
    $IMAGE = $_FILES['image'];
    $image_location = $_FILES['image']['tmp_name'];/** le chemin temporaire où le fichier est stocké sur le serveur. */
    $image_name = $_FILES['image']['name'];
    move_uploaded_file($image_location,'images/'.$image_name);/**éplace le fichier téléchargé de son emplacement temporaire vers le dossier images sur le serveur. */
    $image_up = "images/".$image_name;/** le chemin complet de l'image qui sera stocké dans la base de données. */
    $update = "UPDATE products SET name='$NAME' , price='$PRICE', image='$image_up' WHERE id=$ID";
    mysqli_query($con, $update);

    header('location: index.php');
}
?>
