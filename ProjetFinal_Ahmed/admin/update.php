<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier | Modifier un produit</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <?php
    include('config.php');
    $ID=$_GET['id'];
    $up = mysqli_query($con, "select * from products where id =$ID");
    $data = mysqli_fetch_array($up);
    
    ?>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="up.php" method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                <h2 class="text-center mb-4">Modifier un produit</h2>
                <div class="form-group" style="display:none;">
                    <input type="text" class="form-control" name='id' value='<?php echo $data['id']?>'>
                </div>
                <div class="form-group p-3">
                    <input type="text" class="form-control rounded-pill" name='name' value='<?php echo $data['name']?>' placeholder="Nom du produit">
                </div>
                <div class="form-group p-3">
                    <input type="text" class="form-control rounded-pill" name='price' value='<?php echo $data['price']?>' placeholder="Prix du produit">
                </div>
                <div class="form-group p-3">
                    <textarea class="form-control rounded" name='description' placeholder="Description du produit" rows="4"><?php echo $data['description']?></textarea>
                </div>
                <div class="form-group p-3">
                    <label for="file" class="mb-2 d-block"><strong>Mettre à jour l'image du produit :</strong></label>
                    <input type="file" id="file" name='image' class="form-control-file">
                </div>
                <div class="form-group text-center p-3">
                    <button type="submit" name='update' class="btn btn-primary btn-block rounded-pill">Modifier le produit</button>
                </div>
                <div class="text-center">
                    <a class="btn btn-secondary btn-block rounded-pill" href="products.php">Voir tous les produits</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
