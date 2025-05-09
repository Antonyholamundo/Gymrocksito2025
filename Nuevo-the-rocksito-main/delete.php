<?php

// 1 reference | 0 implementations
class Cliente
{
    // 1 reference | 0 overrides
    public function __construct(
        public string $cedula,
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $correo
    ) {
    }
}

session_start();

foreach ($_SESSION["misclientes"] as $indice => $value) {
    if ($_GET["cedula"] == $value->cedula) {
        echo "LO ENCONTRÉ";
        unset($_SESSION["misclientes"] [$indice]);
    }
}
header(header: "Location: /");


?>