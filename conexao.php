<?php

$host = "192.168.10.36";

$banco = "manutencao";

$usuario = "postgres";

$senha = "Gnms@2020";

$pdo = new PDO(
    "pgsql:host=$host;port=5432;dbname=$banco",
    $usuario,
    $senha

);
