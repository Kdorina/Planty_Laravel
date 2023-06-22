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
use Carbon\Carbon;

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
    public function show($id){
        $show = Water::find($id);

        if(is_null($show)){
            return $this->sendError( new WaterResources($show) , 'nem létezik ilyen');
        }
        return $this->sendResponse( new WaterResources($show) , 'sikeres lekérés');
    }

    public function update(Request $request, $id){

        $input = $request->all();

        $validation = Validator::make($input,[
            "addWater" => "required"
        ]);

        if($validation->fails()){
            return $this->sendError($validation, 'Hiba! Sikertelen szerkeztés');
        }

        $water = Water::find($id);
        $water->update([
            "addWater"=>$request->addWater
        ]);

        return $this->sendResponse( new WaterResources($water), 'Sikeres szerkeztés');
    }
    public function destroy($id){
        $water = Water::find($id);
        $water->delete();
        return $this->sendResponse(new WaterResources($water), "Sikeres törlés.");

    }


    public function WateringReminder(){

        $lastOne = Water::orderBy('created_at', 'desc')->first(); //-> az utolsó értéket adja vissza

        $penultimate = DB::table('waters')->select('created_at')->offset(1)->limit(1)->get();  //-> az utolsó előtti értéket adja vissza

        /* $water = $lastOne->created_at; */
        $water = $penultimate[0]->created_at;

        $carbon = Carbon::parse($water);
        $carbon->addDays(2);
        /* return $carbon; */


       /*  $lastOne->created_at = $carbon->toDateString();
        $lastOne->save(); */ // <- kicseréli az előzző dátumot 2 nappal és javitja az adatbázisban
       /*  return $lastOne; */

        if($carbon = $lastOne){
            return "nem kell megöntöznöd csak 2 nap mulva";
        }else{
            return "Figyelem! 2 napja már nem öntözted meg a növényedet!" ;

        }
    }
}
