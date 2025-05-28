<?php
function calcularFrete($subtotal) {
    if ($subtotal >= 52.00 && $subtotal <= 166.59) return 15.00;
    if ($subtotal > 200.00) return 0.00;
    return 20.00;
}
