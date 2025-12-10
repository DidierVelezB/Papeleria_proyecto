<?php
require __DIR__ . '/../env_loader.php';
require __DIR__ . '/../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

// Verificar si la clave existe
$stripeSecret = getenv('STRIPE_SECRET_KEY') ?: ($_ENV['STRIPE_SECRET_KEY'] ?? null);

if (!$stripeSecret) {
    die(json_encode(['error' => 'No se encontró STRIPE_SECRET_KEY. Verifica el archivo .env']));
}

Stripe::setApiKey($stripeSecret);

// Leer JSON del carrito
$data = json_decode(file_get_contents('php://input'), true);
$total = isset($data['total']) ? intval($data['total']) : 0;

// Validar total
if ($total <= 0) {
    echo json_encode(['error' => 'Total inválido']);
    exit;
}

//  Validar monto mínimo exigido por Stripe (~2000 COP)
if ($total < 2000) {
    echo json_encode([
        'error' => 'El monto mínimo de pago es de $2.000 COP. '
                 . 'Por favor aumenta el valor de tu compra o agrega más productos al carrito.'
    ]);
    exit;
}

// Crear sesión de Stripe
header('Content-Type: application/json');

try {
    $checkout_session = Session::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'line_items' => [[
            'price_data' => [
                'currency' => 'cop',
                'product_data' => ['name' => 'Compra Papelería Punto Escolar'],
                'unit_amount' => $total * 100, // Monto en centavos
            ],
            'quantity' => 1,
        ]],
        'success_url' => 'http://localhost:3000/pagos/success.php',
        'cancel_url'  => 'http://localhost:3000/pagos/cancel.php',
    ]);

    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
