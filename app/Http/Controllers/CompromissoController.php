<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Compromisso;

class CompromissoController extends Controller
{
    //criar compromisso
    public function createCompromisso(Request $request) {
        $array = ['error' => ''];

        //regras para validação
        $rules = [
            'date' => 'required|date',
            'people' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'city' => 'string',
            'state' => 'string'
        ];

        //passa para o validador 
        $validator = Validator::make($request->all(), $rules);

        //se der algum problema
        if($validator->fails()) {
            $array['errors'] = $validator->messages();
            return $array;
        } 

        //pega os campos com request
        $date = $request->input('date');
        $people = $request->input('people');
        $title = $request->input('title');
        $description = $request->input('description');
        $city = $request->input('city');
        $state = $request->input('state');

        //insere informações no bd
        $compromisso = new Compromisso;
        $compromisso->date = $date;
        $compromisso->people = $people;
        $compromisso->title = $title;
        $compromisso->description = $description;
        $compromisso->city = $city;
        $compromisso->state = $state;
        $compromisso->save();

        return $array;
    }

    //ler todos os compromissos
    public function readAllCompromissos() {
        $array = ['error' => ''];

        $compromissos = Compromisso::simplePaginate(2);

        $array['list'] = $compromissos->items();
        $array['current_page'] = $compromissos->currentPage();

        return $array;
    }

    //ler um únic compromisso
    public function readCompromisso($id) {
        $array = ['error' => ''];

        $compromisso = Compromisso::find($id);

        if($compromisso) {
            $array['compromisso'] = $compromisso;
        } else {
            $array['error'] = 'O compromisso '.$id.' não foi encontrado.';
        }

        return $array;
    }

    //atualizar compromisso
    public function updateCompromisso(Request $request, $id) {
         //1º - Faz a validação 
        $array = ['error' => ''];

        $rules = [
            'date' => 'date',
            'people' => 'string',
            'title' => 'string',
            'description' => 'string',
            'city' => 'string',
            'state' => 'string',
            'done' => 'boolean'
        ];

        //passa o validador do validator
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        //pega os campos com request
        $date = $request->input('date');
        $people = $request->input('people');
        $title = $request->input('title');
        $description = $request->input('description');
        $city = $request->input('city');
        $state = $request->input('state');
        $done = $request->input('done');

         //2º - Faz a atualização do item 
        $compromisso = Compromisso::find($id);
        if($compromisso) {
            if($date) {
                $compromisso->date = $date;
            }
            if($people) {
                $compromisso->people = $people;
            }
            if($title) {
                $compromisso->title = $title;
            }
            if($description) {
                $compromisso->description = $description;
            }
            if($city) {
                $compromisso->city = $city;
            }
            if($state) {
                $compromisso->state = $state;
            }
            if($done !==NULL) {
                $compromisso->done = $done;
            }

            $compromisso->save();

        } else {
            $array['error'] = 'O compromisso '.$id.' não foi encontrado, logo, não pode ser atualizado.';
        }
        return $array;
    }

    public function deleteCompromisso($id) {
        $array = ['error' => ''];

        $compromisso = Compromisso::find($id);
        $compromisso->delete();
        
        return $array;
    }
}
