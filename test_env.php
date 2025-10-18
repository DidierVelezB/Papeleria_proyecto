<?php
require __DIR__ . '/env_loader.php';

echo "<pre>";
echo "STRIPE_SECRET_KEY: " . getenv('STRIPE_SECRET_KEY') . "\n";
echo "STRIPE_PUBLIC_KEY: " . getenv('STRIPE_PUBLIC_KEY') . "\n";
echo "</pre>";
