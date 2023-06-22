<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Plant;
use Illuminate\Http\UploadedFile;
use Validator;
use App\Http\Resources\Plant as PlantResources;

class PlantController extends BaseController
{
    public function index(){

        $plants =  Plant::all();
        return $plants;

    }

    public function create(Request $request){

        $input = $request->all();

        $validator = Validator::make($input, [
            "name"=>"required",
            "imgpath"=>"required",
            "description"=>"required",
            "watering"=>"required",
            "temperature"=>"required",
            "light_requirement"=>"required",
            "humidity"=>"required",
            "heat_demand"=>"required"
        ]);

        // if($validator->fails()){
        //     return $this->sendError();
        // }

        if(!$request->hasFile('imgpath') && !$request->file('imgpath')->isValid()){
            return response()->json('{"error":" please add image"}');
        }
            $name = $request->file("imgpath")->getClientOriginalName();
            // Storage::disk('local')->put($name, file_get_contents($request->file('imgpath')));
            $path = $request->file('imgpath')->storeAs('public', $name);

        $input = Plant::create([
            "name"=>$request->name,
            "imgpath"=>$name,
            "description"=>$request->description,
            "watering"=>$request->watering,
            "temperature"=>$request->temperature,
            "light_requirement"=>$request->light_requirement,
            "humidity"=>$request->humidity,
            "heat_demand"=>$request->heat_demand,
        ]);

        return $this->sendResponse(new PlantResources($input),'sikeres felvétel.');

    }

    public function show(Request $request, $id){

        $plant= Plant::find($id);

        if(is_null($plant)){
            return $this->sendError('Hiba! Nem létezik ilyen adat.');
        }

        return $this->sendResponse(new PlantResources($plant), "Sikeres adat lekérés.");
    }
    // UPDATE MÉG NEM MŰKÖDIK KÉRDÉS MIÉRT.

    // public function update(Request $request, $id){

    //     $input = $request->all();

    //     $validator = Validator::make($input, [
    //         "name"=>"required",
    //         // "imgpath"=>"required",
    //         "description"=>"required",
    //         "watering"=>"required",
    //         "temperature"=>"required",
    //         "light_requirement"=>"required",
    //         "humidity"=>"required",
    //         "heat_demand"=>"required"
    //     ]);

    //     if (!$request->hasFile('imgpath')) {
    //         if ($request->imgpath) {
    //             Storage::delete('public/images/' . $request->imgpath);
    //         }
    //     } else {
    //         $image = $request->file('imgpath')->getClientOriginalName();
    //         $path = $request->file('imgpath')->storeAs('public/images', $image);
    //     }

    //     $plant = Plant::find($id);
    //     $plant->update([
    //         "name" => $request->name,
    //         "imgpath" => $path ?? $request->imgpath,
    //         "description" => $request->description,
    //         "watering" => $request->watering,
    //         "temperature" => $request->temperature,
    //         "light_requirement" => $request->light_requirement,
    //         "humidity" => $request->humidity,
    //         "heat_demand" => $request->heat_demand
    //     ]);

    //     return $this->sendResponse(new PlantResources($input),'Sikeres szerkeztés.');


    // }

    public function destroy(Request $request , $id){
        $plant = Plant::find($id);
        $plant->delete();
        return $this->sendResponse(new PlantResources($plant), "Sikeres törlés.");
    }
}
