<?php
session_start();
require_once 'config.php'; // cargamos la key secreta y definimos IVA

if (empty($_SESSION['cart'])) {
    echo "El carrito está vacío.";
    exit;
}

// Calculamos subtotal y total
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += floatval($item['price']);
}
$totalConIVA = $subtotal * (1 + IVA);
$totalCentimos = (int) round($totalConIVA * 100);

// Creamos la sesión de pago
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => 'Compra en John Commerce'],
                'unit_amount' => $totalCentimos,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/M12/ECommerceProject/success.php',
        'cancel_url'  => 'http://localhost/M12/ECommerceProject/cancel.php',
    ]);

    header("Location: {$session->url}");
    exit;
} catch (Exception $e) {
    echo 'Error al crear sesión de pago: ' . $e->getMessage();
}
