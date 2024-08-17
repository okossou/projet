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

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active fw-bold" aria-current="page" href="#">Moto Store</a>
        </li>
      </ul>


      <ul class=" d-flex navbar-nav me-auto mb-4 mb-lg-0">
        <li class="d-flex nav-item">
          <a class="nav-link active fw-bolder fs-5 pe-5" >Bienvenue <?php echo "ADMIN" ?> </a>
        </li>
      </ul>
        <li class="d-flex nav-item">
    <a href="admin_users.php" class="badge text-bg-danger m-3 text-decoration-none fs-7" onclick="return confirm('Voulez-vous vraiment quitter cette page ?');">Gestion des utilisateurs</a>
</li>
    </div>
  </div>
</nav>


<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="insert.php" method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow">
                <h2 class="text-center mb-4">Boutique en ligne</h2>
                <div class="form-group p-3">
                    <input type="text" class="form-control rounded-pill" name='name' placeholder="Nom du produit">
                </div>
                <div class="form-group p-3">
                    <input type="text" class="form-control rounded-pill" name='price' placeholder="Prix du produit">
                </div>
                <div class="form-group p-3">
                    <textarea class="form-control rounded" name='description' placeholder="Description du produit" rows="4"></textarea>
                </div>
                <div class="form-group p-3">
                    <label for="file" class="mb-2 d-block "><strong>Choisir une image de produit :</strong></label>
                    <input type="file" id="file" name='image' class="form-control-file">
                </div>
                <div class="form-group text-center p-3">
                    <button type="submit" name='upload' class="btn btn-primary btn-block rounded-pill">Télécharger le produit </button>
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
