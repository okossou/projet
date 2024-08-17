<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne | Ajouter des produits</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="inde.css">

</head>
<?php
include('config.php');

$sql_orders = "SELECT id, user_id, name, address, phone, created_at FROM orders ORDER BY created_at DESC";
$result_orders = mysqli_query($con, $sql_orders);

if (!$result_orders) {
    die("Erreur SQL : " . mysqli_error($con));
}

if (mysqli_num_rows($result_orders) > 0) {
    echo "<table>";
    echo "<tr><th>ID de commande</th><th>ID utilisateur</th><th>Nom</th><th>Adresse</th><th>Téléphone</th><th>Date de création</th><th>Articles de la commande</th></tr>";
    while ($order = mysqli_fetch_assoc($result_orders)) {
        echo "<tr><td>{$order['id']}</td><td>{$order['user_id']}</td><td>{$order['name']}</td><td>{$order['address']}</td><td>{$order['phone']}</td><td>{$order['created_at']}</td>";
        
        $sql_items = "SELECT product_name, product_price, quantity FROM order_items WHERE order_id = {$order['id']}";
        $result_items = mysqli_query($con, $sql_items);
        if ($result_items && mysqli_num_rows($result_items) > 0) {
            echo "<td><ul>";
            while ($item = mysqli_fetch_assoc($result_items)) {
                echo "<li>{$item['product_name']}: Prix - {$item['product_price']}, Quantité - {$item['quantity']}</li>";
            }
            echo "</ul></td>";
        } else {
            echo "<td>Aucun article trouvé pour cette commande.</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucune commande trouvée.";
}
?>
