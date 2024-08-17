<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit;
}


// Fetch users details pour database
$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
if(mysqli_num_rows($select_user) > 0){
    $fetch_user = mysqli_fetch_assoc($select_user);
}

// Fetch items de cart affichage
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
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
          <a class="nav-link active fw-bolder" aria-current="page" href="index.php">Plant Store</a>
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
          <a class="nav-link active fw-bolder fs-5 pe-5" >Bienvenue</a>
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
   
<div class="container">
    
    <div class="shopping-cart checkout">
       <h1 class="title p-5 text-center">Récapitulatif de la commande</h1>
       <table>
          <thead>
             <th>Image</th>
             <th>Nom</th>
             <th>Prix</th>
             <th>Quantité</th>
             <th>Total</th>
          </thead>
          <tbody>
          <?php
             if(mysqli_num_rows($cart_query) > 0){
                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                   $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                   $grand_total += $sub_total;
          ?>
         <tr>
            <td><img src="admin/<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td><?php echo $fetch_cart['price']; ?>€ </td>
            <td><?php echo $fetch_cart['quantity']; ?></td>
            <td><?php echo $sub_total; ?>€</td>
         </tr>
         <?php
                }
             } else {
                echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="5">Le panier est vide</td></tr>';
             }
         ?>
      <tr class="table-bottom">
         <td colspan="4">Total :</td>
         <td><?php echo $grand_total; ?>€</td>
      </tr>
   </tbody>
   </table>

   <h2 class="pt-5 pb-5">Informations de Livraison</h2>
   <form action="process_order.php" method="POST">
   <div class="mb-3">
      <label for="name" class="form-label">Nom:</label>
      <input type="text" id="name" name="name"  class="form-control" required>
      
      <label for="address" class="form-label">Adresse:</label>
      <input type="text" id="address" name="address"  class="form-control" required>

      <label for="phone" class="form-label">Téléphone:</label>
      <input type="text" id="phone" name="phone" class="form-control" required>

      <input type="submit" value="Passer la commande" name="checkout" class="btn btn-primary">
            </div>
   </form>

   </div>
</div>

</body>
</html>
