<?php

### Variables y Tipos de Datos
$edad = 10;
$puntaje = 7.50;
$respuesta = "Ingresado correctamente";
$online = true;
var_dump($online);

function doblarEdad($edad) {
	return $edad * 2;
}

### Operadores

function operaciones($op, $n1, $n2) {
	switch($op) {
	  case "s":
		return $n1 + $n2;
		break;
	  case "r":
		return $n1 - $n2;
		break;
	  case "m":
		return $n1 * $n2;
		break;
	  case "d":
		return $n1 / $n2;
		break;
	};
};

function esMayor($n1, $n2) {
	if ($n1 == $n2) {
	  echo "Los valores son iguales\n";
	} else if ($n1 > $n2) {
	  echo "El primer valor es mayor\n";
	} else {
	  echo "El segundo valor es mayor\n";
	};
};

function concatenar($s1, $s2) {
	echo $s1 . $s2;
};

### Estructuras de control

function esMayorDeEdad($edad) {
	echo ($edad < 18 ? "Menor de edad" : "Mayor de Edad");
};

function bucle() {
	for ($i = 0; $i <= 20; $i++) {
	   echo $i;
	};
};

function sumaBucle($n) {
	$suma = 0;
	while($n >= 50) {
		for($i = 0; $i < 10; $i++) {
			$suma += $i;
		}
		break; 
	}
	return $suma;
}


$nombres = ["Juan", "Jose", "Marcos", "Lucas"];

function recorrerArray($nombres) {
	foreach($nombres as $nombre) {
	   echo $nombre;
	};
};

function diaSemana($d) {
	switch($d) {
	   case 1:
		echo "1: Lunes";
		break;
	   case 2:
		echo "2: Martes";
		break;
	   case 3:
		echo "3: Miercoles";
		break;
	   case 4:
		echo "4: Jueves";
		break;
	   case 5:
		echo "5: Viernes";
		break;
	   case 6:
		echo "6: Sabado";
		break;
	   case 7:
		echo "7: Domingo";
		break;
	};
 };