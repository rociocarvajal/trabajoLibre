<?php

 # Trabajo Final Libre - Introducción a la Programación 

 /**
 * Función que retorna array de datos de la red social.
 * Esta funcion carga y retorna algunos datos como: id, nick, cantLikes, cantComent
 * @return array 
 */

 function redSocial() 
 {
    $datos[0] = array (
        "id" => "H1523",
        "nick" => "juan",
        "cantLikes" => 45,
        "cantComent" => 15
    );
    $datos[1] = array (
        "id" => "P147",
        "nick" => "facu10",
        "cantLikes" => 12,
        "cantComent" => 65
    );
    $datos[2] = array (
        "id" => "P7811",
        "nick" => "juan",
        "cantLikes" => 25,
        "cantComent" => 30
    );
    $datos[3] = array (
        "id" => "H2587",
        "nick" => "marcia01",
        "cantLikes" => 36,
        "cantComent" => 0
    );
    $datos[4] = array (
        "id" => "H1689",
        "nick" => "marcia01",
        "cantLikes" => 81,
        "cantComent" => 26
    );
    return $datos;
 }

/**
 * Función que reciba por parametro un array asociativo y devuelva los datos de este mismo, clasificandolos por historia o publicación.
 * @param array $comunicacion
 */

    function mostrarData ($comunicacion) {
    $id = $comunicacion['id'];
    $firstLetter = substr($id, 0, 1);
     //substr() --> devuelve la primera letra de una cadena definida por los parametros start y length
     if ($firstLetter == "H") {
        $type = "Historia";
    }
    else {
        $type = "Publicacion";
    }
    $autor = $comunicacion['nick'];
    $likes = $comunicacion['cantLikes'];
    $coment = $comunicacion['cantComent'];
    echo "- Comunicación: $id\n";
    echo "- Tipo: $type\n";
    echo "- Autor: $autor\n";
    echo "- Me gustas: $likes\n";
    echo "- Comentarios: $coment\n";
    }

  /**
   * Función que segun un array, retorne el indice de la comunicación con mayor cantidad de likes.
   * @param array $datos
   * @return int $newIndex
   */

  function moreLikes ($datos) {
    $n = count($datos);
    $valorA = $datos[0]["cantLikes"];
    $valorB = $datos[1]["cantLikes"];
    for ($i=0; $i < $n ; $i++) { 
        if ($valorA < $datos[$i]["cantLikes"]) {
            $valorA = $datos[$i]["cantLikes"];
            $newIndex = $i;
        }
        elseif ($valorA > $valorB) {
            $valorB = $valorA;
            $valorA = $datos[$i]["cantLikes"];
            $newIndex = $i;
        }
    }
    return $newIndex;
   }

      /**
    * Funcion que segun un input de nickname, retorne un valor para determinar si es valido o evaluarlo segun condiciones.
    * @param array $datos
    * @param string $nickname
    * @return int $n
    */

    function validarNickname ($datos, $nickname) {
        $n = 0;
        $i = 0;
        $found = false;
        while ($found == false && $i < count($datos)) {
            $newIndex = 0;
            if ($datos[$i]["nick"] == $nickname) {
                $newIndex = $newIndex + $i;
                $nLikes = $datos[$newIndex]["cantLikes"];
                $nComents = $datos[$newIndex]["cantComent"];
                if ($nComents > $nLikes) {
                    $n = $newIndex;
                    $found = true;
                }
                else {
                    $n = -1;
                }
            }
            else {
                $n = -2;
            }
            $i++;
        }
        return $n;
    }

       /**
    * Función que encuentra a los mayores likes segun un número ingresado y retorna cantidad.
    * @param array $datos
    * @param int $inputLikes
    * @return array $indexado
    */

    function maxLikes($datos, $inputLikes) {
        $indexado = [];
        $i = 0;
        for ($i=0; $i < count($datos); $i++) { 
            if ($datos[$i]["cantLikes"] > $inputLikes) {
                $newArray[] = $datos[$i]["id"];
                $indexado[] = $newArray;
                
            }
            else {
                $i++;
            }
        }
        return $indexado;
    }


/**
 * Función solicitar nueva comunicacion y agregarlo al array precargado.
 * @param array $datos
 * @return array $datos
 */

function add ($datos) {
    // Solicito datos al usuario
    echo "Ingrese id: ";
    $id = trim(fgets(STDIN));
    echo "Ingrese nickname: ";
    $nickname = trim(fgets(STDIN));
    $nickname = strtolower($nickname);
    echo "Ingrese cantidad de likes: ";
    $nLikes = trim(fgets(STDIN));
    echo "Ingrese cantidad de comentarios: ";
    $nComents = trim(fgets(STDIN));
    // Crear nuevo array y cargar los datos
    $newDato = array (
        "id" => $id,
        "nick" => $nickname,
        "cantLikes" => $nLikes,
        "cantComent" => $nComents
    );
    $datos[] = $newDato;
    return $datos;
 }

// Programa principal

$data = redSocial();
echo "Ingrese cantidad de comunicaciones que desea agregar: ";
$cantComunicaciones = trim(fgets(STDIN));
if ($cantComunicaciones != 0) {
    for ($i=0; $i < $cantComunicaciones; $i++) { 
        $data = add($data);
      }
  }
  else {
    echo "No se ingresaron comunicaciones.\n";
    $data = $data;
  }
$index = moreLikes($data);
echo "La comunicacion con mas likes es: \n";
$asociativo = $data[$index];
mostrarData($asociativo);
echo "Ingrese nickname: ";
$nick = trim(fgets(STDIN));
$nick = strtolower($nick);
$number = validarNickname($data, $nick);
if ($number >= 0) {
    $newAsociativo = $data[$number];
    echo "La primera comunicacion de $nick, que los comentarios superan a los likes es: \n";
    print_r($newAsociativo);
}
elseif ($number == -1) {
    echo "$nick existe en la base de datos, pero en ninguna de sus publicaciones los comentarios superan likes.\n";
}
else {
    echo "$nick no existe en la base de datos.\n";
}
echo "Ingrese cantidad de likes a superar: ";
$nLikes = trim(fgets(STDIN));
$indexado = maxLikes($data, $nLikes);
$cantidad = count($indexado);
echo "La cantidad de comunicaciones que los likes superan input es un total de: $cantidad.\n";

?>
