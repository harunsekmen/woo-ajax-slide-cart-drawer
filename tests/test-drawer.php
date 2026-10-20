<?php
require_once __DIR__ . '/bootstrap.php';
require_once dirname(__DIR__) . '/includes/class-slide-cart-engine.php';

echo "Testing Woo_Slide_Cart_Engine...
";
$engine = Woo_Slide_Cart_Engine::instance();
assert($engine instanceof Woo_Slide_Cart_Engine, "Instance check");
$frags = $engine->update_fragments([]);
assert(isset($frags['span.wascd-cart-counter']), "Fragment key check");
$progress = $engine->calculate_shipping_progress(50.00);
assert($progress['percentage'] === 67, "Progress calculation check");
echo "PASS: Woo_Slide_Cart_Engine verified.
";
