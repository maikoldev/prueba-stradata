<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diccionario;

class AccuracyPercentageController extends Controller
{
    public function normalize_name($name){
        // Dividimos el array para eliminar los espacios entre las palabras
        $splitted_name = explode(" ", $name);

        // Aqui volvemos a unir las palabras ya sin espacios
        // Esto se hace con el fin de "aumentar" el porcentaje de coincidencia.
        $joined_name = join($splitted_name);

        // Por ultimo ponemos en minusculas todo el texto
        $lowered_name = strtolower($joined_name);

        return $lowered_name;
    }

    public function index(Request $req)
    {
        // Rescata todos los registros
        $names = Diccionario::all();

        $filtered_names = $names->filter(function($item) use ($req) {
            $name = $item->nombre;

            // Se normalizan cada nombre del array y el nombre ingresado,
            // se remeuven los espacios y se pone en minusculas
            $req_name = $this->normalize_name($req->name);
            $dic_name = $this->normalize_name($name);

            // Se usa la funcion "similar_text" ya que me parecio mas efectivo para este ejercico
            // enves de "levenshtein", ya que tocaba modificarlo menos.
            $distance = similar_text($req_name, $dic_name);

            // Se trae el numero de palabras que coinciden, se divide por el numero de letras del nombre ingresado
            // y se multiplicado por 100, para dar un valor en porcentaje de 100, luego se redondea a dos cifras,
            // y por ultimo se añade al objeto recorrido como "percentage", esto luego se usara en el front.
            $percentage = $distance > 0 ? ($distance / strlen($req_name))*100 : 0;
            $rounded_percentage = round($percentage, 2);
            $item['percentage'] = $rounded_percentage;

            // Por ultimo se pone la condición del filtro y se devuelve los que tengan mayor o igual porcentaje al ingresado.
            return $rounded_percentage >= $req->percentage;
        });

        // Se ordena el array filtrado por el key "percentage" y en orden descendente.
        $sorted_names = $filtered_names->sortByDesc("percentage");

        // Se valida que hayan elementos en el array, sino devuelve mensaje informativo.
        // Si hay registros se devuelve la respuesta, con su estado y los registros.
        if(count($sorted_names) > 0){
            return response()->json([
                "searched_name" => $req->name,
                "searched_percentage" => $req->percentaje,
                "names_found" => $sorted_names->values(),
                "status" => 200
            ]);
        } else {
            return response()->json([
                "message" => 'No hay coincidencias'
            ]);
        }
    }

}
