<?php

$conexion = mysqli_connect("localhost", "root", "");

if (mysqli_connect_error())
{
    echo "Ocurrió un fallo en la conexión con MySQL: " . mysqli_connect_error();
    die();
}