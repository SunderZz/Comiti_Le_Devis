<?php
// Crée le token avec 32 bytes aléatoire si il n'existe pas
function CreateToken() {
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token'];
}

// Verifie si le token existe dans la session et si il correspond
function ValideToken($token) {
    return isset($_SESSION['token']) && hash_equals($_SESSION['token'], $token);
}
?>