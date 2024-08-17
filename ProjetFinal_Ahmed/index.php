
<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit; // Always exit after a header redirect
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    header('location:login.php');
    exit;
}

$message = []; // Initialize an empty array for messages

if (isset($_POST['add_to_cart'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'");
    
    if(mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Le produit est déjà ajouté au panier !';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')");
        $message[] = 'Le produit est ajouté au panier !';
    }
}

if (isset($_POST['update_cart'])) {
    $update_quantity = mysqli_real_escape_string($conn, $_POST['cart_quantity']);
    $update_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'");
    $message[] = 'La quantité du panier a été mise à jour avec succès !';
}

if (isset($_GET['remove'])) {
    $remove_id = mysqli_real_escape_string($conn, $_GET['remove']);
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header('location:index.php');
    exit;
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
    header('location:index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Panier</title>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">



   <style>
       

        .card-img-top {
            height: 400px; /* Fixed image height */
            
        }

       

        

        
    </style>
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="" width="60" height="50"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active fw-bold" aria-current="page" href="#">Bmw Moto</a>
        </li>
      </ul>

      <?php
          $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
          if(mysqli_num_rows($select_user) > 0){
             $fetch_user = mysqli_fetch_assoc($select_user);
          }
       ?>


      <ul class=" d-flex navbar-nav me-auto mb-4 mb-lg-0">
        <li class="d-flex nav-item">
          <a class="nav-link active fw-bolder fs-5 pe-5" >Bienvenue </a>
        </li>
      </ul>
      <li class="d-flex nav-item pe-3">
          <a class="nav-link" href="checkout.php"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
</svg></a>
        </li>
        <li class="d-flex nav-item">
         <a href="index.php?logout=<?php echo $user_id; ?>" class="badge text-bg-danger m-3 text-decoration-none fs-7" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?');">Déconnexion</a>
        </li>
    </div>
  </div>
</nav>
<body>
   
<?php
if (!empty($message)) {
   foreach($message as $msg) {
      echo '<div class="message" onclick="this.remove();">'.$msg.'</div>';
   }
}
?>

<div class="container">
    

    <div class="products">
       <h1 class="title p-5">Découvrez l'excellence et la puissance des motos BMW, où chaque trajet devient une aventure inoubliable</h1>
       <div class="box-container">
       <div class="row row-cols-1 text-center row-cols-md-3 g-4">
       <?php
       $result = mysqli_query($conn, "SELECT * FROM products");      
       while($row = mysqli_fetch_array($result)){
       ?>
      
          
          <form method="post"  action="">
          <div class="row">
    <div class="col">
        <div class="card h-100">
            <img src="admin/<?php echo $row['image']; ?>" class="card-img-top" alt="Image 1">
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo $row['name']; ?>
                    <span class="badge text-bg-success m-3"><?php echo $row['price']; ?></span>
                </h5>
                <input type="number" class="form-control" min="1" name="product_quantity" value="1">
                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                <p class="card-text"><?php echo $row['description']; ?></p>
                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

         </form>
      
       <?php
          };
       ?></div>
       </div>
    </div>

    <div class="shopping-cart">
       <h1 class="title text-center p-5"> Panier</h1>
       <table>
          <thead>
             <th>Image</th>
             <th>Nom</th>
             <th>Prix</th>
             <th>Quantité</th>
             <th>Total</th>
             <th>Actions</th>
          </thead>
          <tbody>
          <?php
             $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
             $grand_total = 0;
             if(mysqli_num_rows($cart_query) > 0){
                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                   $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                   $grand_total += $sub_total;
          ?>
         <tr>
            <td><img src="admin/<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td><?php echo $fetch_cart['price']; ?>€ </td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="Mettre à jour" class="option-btn">
               </form>
            </td>
            <td><?php echo $sub_total; ?>€</td>
            <td><a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('Voulez-vous supprimer cet élément du panier ?');">Supprimer</a></td>
         </tr>
         <?php
                }
             } else {
                echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">Le panier est vide</td></tr>';
             }
         ?>
      <tr class="table-bottom">