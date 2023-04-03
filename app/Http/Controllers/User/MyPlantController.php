<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MyPlant;
use App\Models\User;
use Validator;
use DB;
use App\Models\Plant;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\MyPlant as MyPlantResource;

class MyPlantController extends BaseController
{
    public function index(Request $request){

        if(Auth::check()){
            $user_id = Auth::user()->id;
            /* $myplant = DB::table('myplants')->where(['user_id'=> $user_id])->get(); */
            /* return $this->sendResponse(new MyPlantResource($myplant), "Sikeres lekérés"); */

       $plant= DB::select("SELECT plants.*, myplants.user_id from plants
       inner join myplants on plants.id=myplants.plant_id
       where myplants.user_id=$user_id");

    }
    return $plant;
}

    public function create(Request $request){

        if (Auth::check())
        {
            $id = Auth::user()->getId();
        }

        $input = $request->all();
         $input['plant_id'] = Plant::where('id', $input['plant_id'])->first()->id;

        $validation = Validator::make($input,[
            'plant_id'=>'required'
        ]);

        if($validation->fails()){
            return $this->sendError($validation, 'Hiba! Sikertelen felvétel');
        }

        $plant = MyPlant::create([
            "user_id"=>$id,
            "plant_id"=>$request->plant_id
        ]);
        return $this->sendResponse( new MyPlantResource($plant), "Sikeres feltöltés");
    }

    public function show(){

    }

    public function destroy($id){
        $myplant = MyPlant::find($id);
        $myplant->delete();
        return $this->sendResponse(new MyPlantResource($myplant), "Sikeres törlés.");

    }
}
