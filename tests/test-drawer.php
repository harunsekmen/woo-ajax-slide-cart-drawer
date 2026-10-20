<?php
require_once __DIR__ . '/bootstrap.php';
require_once dirname(__DIR__) . '/includes/class-slide-cart-engine.php';

echo "Testing Woo_Slide_Cart_Engine...
";
$engine = Woo_Slide_Cart_Engine::instance();
assert($engine instanceof Woo_Slide_Cart_Engine, "Instance check");
$frags = $engine->add_drawer_fragments([]);
assert(isset($frags['span.wascd-cart-counter']), "Fragment counter key check");
echo "PASS: Woo_Slide_Cart_Engine verified.
";
