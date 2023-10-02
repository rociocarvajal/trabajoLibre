<?php

# Trabajo Final Libre - Introducción a la Programación 

/**
 * Función que retorna array de comunicaciones de la red social.
 * Esta funcion carga y retorna algunos datos como: id, nick, cantLikes, cantComent
 * @return array 
 */

 function redSocial() 
 {
    $comunicaciones[0] = array (
        "id" => "H1523",
        "nick" => "juan",
        "cantLikes" => 45,
        "cantComent" => 15
    );
    $comunicaciones[1] = array (
        "id" => "P147",
        "nick" => "facu10",
        "cantLikes" => 12,
        "cantComent" => 65
    );
    $comunicaciones[2] = array (
        "id" => "P7811",
        "nick" => "juan",
        "cantLikes" => 25,
        "cantComent" => 30
    );
    $comunicaciones[3] = array (
        "id" => "H2587",
        "nick" => "marcia01",
        "cantLikes" => 36,
        "cantComent" => 0
    );
    $comunicaciones[4] = array (
        "id" => "H1689",
        "nick" => "marcia01",
        "cantLikes" => 81,
        "cantComent" => 26
    );
    return $comunicaciones;
 }

 /**
  * Función que reciba por parametro un array asociativo y devuelva los datos de este mismo, clasificandolos por historia o publicación.
  * @param array $comunicaciones
  * @param int $i
  */

  function mostrarData($comunicaciones, $i) {
    $id = $comunicaciones[$i]["id"];
    $firstLetter = substr($id, 0, 1);
    //substr() --> devuelve la primera letra de una cadena definida por los parametros start y length
    if ($firstLetter == "H") {
        $type = "Historia";
    }
    else {
        $type = "Publicacion";
    }
    $autor = $comunicaciones[$i]["nick"];
    $likes = $comunicaciones[$i]["cantLikes"];
    $coment = $comunicaciones[$i]["cantComent"];
    echo "- Comunicación: $id\n";
    echo "- Tipo: $type\n";
    echo "- Autor: $autor\n";
    echo "- Me gustas: $likes\n";
    echo "- Comentarios: $coment\n";
  } 

 /**
   * Función que segun un array, retorne el indice de la comunicación con mayor cantidad de likes.
   * @param array $comunicaciones
   * @return int
   */

   function moreLikes ($comunicaciones) {
    $n = count($comunicaciones);
    $valorA = $comunicaciones[0]["cantLikes"];
    for ($i=0; $i < $n ; $i++) { 
        if ($valorA < $comunicaciones[$i]["cantLikes"]) {
            $valorA = $comunicaciones[$i]["cantLikes"];
            $newIndex = $i;
        }
    }
    return $newIndex;
   }

   /**
    * Funcion que segun un input de nickname, retorne un valor para determinar si es valido o evaluarlo segun condiciones.
    * @param string $nickName
    * @param array $comunicaciones
    * @return int
    */

    function validarNick ($nickName, $comunicaciones) {
        $n = 0;
        for ($i=0; $i < count($comunicaciones); $i++) {
            $newIndex = 0;
            if ($comunicaciones[$i]["nick"] == $nickName) {
                $newIndex = $newIndex + $i;
                $nlikes = $comunicaciones[$newIndex]["cantLikes"];
                $nComents = $comunicaciones[$newIndex]["cantComent"];
                if ($nComents > $nlikes) {
                    $n = $n + 100000;
                    echo "Primer comunicacion de $nickName que los comentarios superan likes: \n";
                    mostrarData($comunicaciones, $newIndex);
                    break;
                }
                else {
                    $n = -1;
                }
            }
            else {
                $n = -2;
            }
        }
        return $n;
    }

   /**
    * Función que encuentra a los mayores likes segun un número ingresado y retorna cantidad.
    * @param array $comunicaciones
    * @param int $number
    * @return int
    */


 function maxLikes($comunicaciones, $number) {
    $counter = 0;
    for ($i=0; $i < count($comunicaciones); $i++) { 
        if ($comunicaciones[$i]["cantLikes"] > $number) {
            $counter = $counter + 1;
        }
        else {
            $counter = $counter;
        }
    }
    return $counter;
 }

/**
 * Función solicitar nueva comunicacion y agregarlo al array precargado.
 * @param array $comunicaciones
 * @return array
 */

 function add ($comunicaciones) {
    // Solicito datos al usuario
    echo "Ingrese id: ";
    $id = trim(fgets(STDIN));
    echo "Ingrese nickname: ";
    $nickname = trim(fgets(STDIN));
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
    $comunicaciones[] = $newDato;
    return $comunicaciones;
 }

 /**
  * Programa principal
  */

  $data = redSocial();
  echo "Ingrese la cantidad de comunicaciones a agregar: ";
  $cantComunicaciones = trim(fgets(STDIN));
  //Recupero el array
  if ($cantComunicaciones != 0) {
    for ($i=0; $i < $cantComunicaciones; $i++) { 
        $data = add($data);
      }
  }
  else {
    echo "No se ingresaron comunicaciones.\n";
    $data = $data;
  }
  $moreLikes = moreLikes($data);
  echo "Datos de la comunicacion con más likes: \n";
  mostrarData($data, $moreLikes);
  echo "Ingrese nickname: ";
  $nick = trim(fgets(STDIN));
  $nick = strtolower($nick);
  $result = validarNick($nick, $data);
  if ($result == -2) {
    echo "Nickname: $nick no encontrado en base de datos, intentar nuevamente.\n";
  }
  elseif ($result == -1) {
    echo "Nickname: $nick existe, pero ninguna de sus comunicaciones tiene mayor cantidad de comentarios, que likes.\n";
  }
  echo "Ingrese cantidad de likes a superar: ";
  $nLikes = trim(fgets(STDIN));
  $moreLikes = maxLikes($data, $nLikes);
  echo "La cantidad de comunicaciones que superan los likes ingresados: ($moreLikes).";
  
  

