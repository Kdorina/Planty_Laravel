<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Water;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Water as WaterResources;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use DB;

class WaterController extends BaseController
{
    public function index(Request $request){
        if(Auth::check()){
            $id = Auth::user()->id;
            $water = DB::table('waters')->where(['user_id'=>$id])->get();
        }
        return $water;
    }

    public function create(Request $request){
        if(Auth::check()){
            $id = Auth::user()->getId();
        }

        $input = $request->all();

        $validation = Validator::make($input,[
            "addWater" => "required"
        ]);

        if($validation->fails()){
            return $this->sendError($validation, 'Hiba! Sikertelen felvétel');
        }

        $input = Water::create([
            "addWater"=>$request->addWater,
            "user_id"=>$id
        ]);

        return $this->sendResponse( new WaterResources($input), 'Sikeres felvétel');

    }
}
