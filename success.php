<?php
session_start();
// Si confías en que solo Stripe puede llegar aquí,
// puedes simplemente vaciar el carrito y dar las gracias.
$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Pago exitoso</title></head>
<body>
<h1>¡Gracias por tu compra!</h1>
<p>Tu pago se ha realizado correctamente.</p>
<a href="index.php">Volver a la página principal</a>
</body>
</html>
