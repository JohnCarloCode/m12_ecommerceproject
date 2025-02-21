<?php
session_start();

// Verificamos si existe el carrito
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Si se recibe acción para eliminar un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $removeId = $_POST['id'];

    // Buscamos el producto en el array de sesión y lo quitamos
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['id'] == $removeId) {
            unset($_SESSION['cart'][$index]);
            break;
        }
    }
    // Re-indexamos el array para que no queden "huecos" en los índices
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Calculamos el subtotal (sumando el precio de cada producto)
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += floatval($item['price']);
}

// Define la tasa de IVA (21%)
$ivaRate = 0.21;

// Calcula el importe de IVA
$ivaAmount = $subtotal * $ivaRate;

// Calcula el total (subtotal + IVA)
$total = $subtotal + $ivaAmount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - John Commerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

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

<div class="container mt-4">
    <h1>Mi Carrito</h1>

    <?php if (empty($_SESSION['cart'])) : ?>
        <div class="alert alert-info" role="alert">
            Tu carrito está vacío.
        </div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?> €</td>
                    <td>
                        <!-- Formulario para eliminar el producto del carrito -->
                        <form action="cart.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Mostramos Subtotal, IVA y Total -->
        <h4>Subtotal (sin IVA): <?php echo number_format($subtotal, 2); ?> €</h4>
        <h4>IVA (21%): <?php echo number_format($ivaAmount, 2); ?> €</h4>
        <h4>Total (con IVA): <?php echo number_format($total, 2); ?> €</h4>

        <!-- Botones de acción -->
        <a href="index.php" class="btn btn-primary">Seguir comprando</a>
        <a href="checkout.php" class="btn btn-success">Proceder al Pago</a>

    <?php endif; ?>
</div>

</body>
</html>
