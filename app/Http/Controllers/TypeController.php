<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Resources\Type as TypeResources;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class TypeController extends BaseController
{
    public function index(Request $request){
        $type = Type::all();
        return $type;
    }

    public function create(Request $request){
        $input = $request->all();
        $validation = Validator::make($input, [
            "name"=>"required"
        ]);
        if($validation->fails()){
            return $this->sendError($validation, "Hiba! Sikertelen felvétel");
        }

        $input = Type::create($input);
        return $this->sendResponse(new TypeResources($input), "Sikeres felvétel.");
    }

    public function show(Request $request, $id){

        $type = Type::find($id);
        
        if(is_null($type)){
            return $this->sendError('Nem létezik ilyen típus!');
        }
        return $this->sendResponse(new TypeResources($type), "Típus lekérdezve.");
    }

    public function update(Request $request, $id){

        $input = $request->all();

        $validation = Validator::make($input, [
            "name"=>"required"
        ]);
        if($validation->fails()){
            return $this->sendError($validation, "Hiba! Sikertelen szerkeztés.");
        }

        $type= Type::find($id);
        $type->update($input);

        return $this->sendResponse(new TypeResources($type), "Sikeres szerkeztés." );
    }

    public function destroy(Request $request, $id){

        $type = Type::find($id);
        $type->delete();
        return $this->sendResponse(new TypeResources($type), "Sikeres törlés.");
    }
}
