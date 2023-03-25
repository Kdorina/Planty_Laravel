<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Disease;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Http\Resources\Disease as DiseaseResources;

class DiseaseController extends BaseController
{
    public function index(Request $request){
        $disease = Disease::all();
        return $this->sendResponse( DiseaseResources::collection($disease), "sikeres lekérés");
    }

    public function create(Request $request){
        $input = $request->all();
        $id["type_id"]= Type::where('id', $input['type_id'])->first()->id;
        $validation = Validator::make($input ,[
            "name" => "required",
            // "imgpath" => "required",
            "type_id" => "required",
            "description" => "required",
            "solution" => "required"
        ]);

        if($validation->fails()){
            return $this->sendError($validation, 'sikertelen felvétel');
        }
        
        if(!$request->hasFile('imgpath') && !$request->file('imgpath')->isValid()){
            return response()->json('{"error":" please add image"}');
        }
            $name = $request->file("imgpath")->getClientOriginalName();
            Storage::disk('public')->put($name, file_get_contents($request->file('imgpath')));
            // $path = $request->file('imgpath')->storeAs('public/images', $name);

        $input = Disease::create([
            "name" => $request->name,
            "imgpath" => $name,
            "type_id" => $id['type_id'],
            "description" => $request->description,
            "solution" => $request->solution
        ]);
        return $this->sendResponse( new DiseaseResources($input), "Sikeres feltöltés");
    }

    public function show(Request $request, $id){
        
    }

    public function update(Request $request, $id){
        
    }

    public function destroy(Request $request, $id){
        
    }
}
