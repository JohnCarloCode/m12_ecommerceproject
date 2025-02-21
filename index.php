<?php
$jsonData = file_get_contents('products.json');
$products = json_decode($jsonData, true);
session_start();

// Verificamos si el carrito está definido en la sesión; si no, lo creamos
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Si ha llegado un POST para añadir al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    // ID del producto enviado por el formulario
    $productId = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price']
    ];

    // Lógica para añadir el producto al carrito
    if ($productId !== null) {
        // Aquí podrías chequear si ya existe y sumar cantidad, etc.
        // Por simplicidad, solo lo meto en el array
        $_SESSION['cart'][] = $productId;
    }

    // Redirige a la misma página, posicionándose en el producto correspondiente
    header("Location: " . $_SERVER['PHP_SELF'] . "#producto-" . $_POST['id']);
    exit();
}

// echo "<pre>";
// var_dump($_SESSION['cart']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">John Commerce</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div id="carouselExampleControls" class="carousel slide w-75 p-3 mx-auto" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.stockx.com/360/Air-Jordan-1-Retro-High-OG-Chicago-Reimagined/Images/Air-Jordan-1-Retro-High-OG-Chicago-Reimagined/Lv2/img18.jpg?w=480&q=57&dpr=2&updated_at=1665692308&h=320" class="d-block w-50 mx-auto" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://images.stockx.com/360/Nike-Air-Force-1-Low-White-07/Images/Nike-Air-Force-1-Low-White-07/Lv2/img18.jpg?w=480&q=57&dpr=2&updated_at=1635275427&h=320" class="d-block w-50 mx-auto" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://images.stockx.com/360/Nike-Air-Max-1-Patta-Chlorophyll-2024/Images/Nike-Air-Max-1-Patta-Chlorophyll-2024/Lv2/img01.jpg?w=480&q=57&dpr=2&updated_at=1725024125&h=320" class="d-block w-50 mx-auto" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>

    <div class="d-flex flex-wrap w-75 p-3 mx-auto">
        <?php foreach ($products as $product) : ?>
            <div class="card mb-2  mr-2" style="width: 15rem;">
                <img src="<?php echo $product['image'] ?>" class="card-img-top " alt="...">
                <div class="card-body d-flex flex-wrap flex-column">
                    <h5 class="card-title mb-auto"><?php echo $product['name'] ?></h5>
                    <p class="card-text"><?php echo $product['price'] . '€' ?></p>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="btn btn-dark">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</body>

</html>