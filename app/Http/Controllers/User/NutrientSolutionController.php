<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NutrientSolution;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\NutrientSolution as NutrientSolutionResources;
use Validator;
use DB;


class NutrientSolutionController extends BaseController
{
    public function index(Request $request){

        if(Auth::check()){
            $id = Auth::user()->id;
            $nutri = DB::table('nutrients')->where(['user_id'=>$id])->get();
        }
        return $nutri;
    }

    public function create(Request $request){

        if(Auth::check()){
            $id = Auth::user()->getId();
        }

        $input = $request->all();

        $validation = Validator::make($input, [
            "addNutrient"=>"required"
        ]);
        if($validation->fails()){
            return $this->sendError($validator, 'Hiba! Sikertelen felvétel');
        }

        $input = NutrientSolution::create([
            "addNutrient"=>$request->addNutrient,
            "user_id"=>$id
        ]);
        return $this->sendResponse( new NutrientSolutionResources($input), 'Sikeres felvétel');
    }
    public function destroy($id){
        $nutrient = NutrientSolution::find($id);
        $nutrient->delete();
        return $this->sendResponse(new NutrientSolutionResources($nutrient), "Sikeres törlés.");

    }
}
