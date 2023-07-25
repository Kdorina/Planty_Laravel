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
            "addWater" => "required",
            "quantity"  => "required"
        ]);

        if($validation->fails()){
            return $this->sendError($validation, 'Hiba! Sikertelen felvétel');
        }

        $input = Water::create([
            "addWater"=>$request->addWater,
            "quantity"=>$request->quantity,
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

        $lastOne = Water::orderBy('created_at', 'desc')->first(); // Retrieves the latest record from the "waters" table

        $penultimate = Water::orderBy('created_at', 'desc')->skip(1)->take(1)->first(); // Retrieves the second-to-last record from the "waters" table

        $currantDate = Carbon::now();

        if ($currantDate->toDateString() === $lastOne->created_at->toDateString()) {
            $nextWateringSession = $currantDate->copy()->addDays(2) ;
            $diffNumber = $currantDate->diffInDays($nextWateringSession);
            return  response()->json(['message'=>"Legközelebb $diffNumber nap múlva kell megöntöznöd"]);// Returns 'nem kell megöntözni' if the current date is equal to the last recorded date


        if($diffNumber < 1){
            return response()->json(['message'=>"Ideje öntözni"]);

            }
        }
       elseif($currantDate->diffInDays($lastOne->created_at) >= 2) {
            $dateSinceLastWatering = $currantDate->diffInDays($lastOne->created_at);
            return  response()->json(['message'=>"Figyelem! $dateSinceLastWatering napja nem öntözted meg a növényedet!"]); // Returns "Figyelem! 2 napja már nem öntözted meg a növényedet!" if the difference between the current date and the last recorded date is greater than 2 days

        }

        else{
            return response()->json(['message'=>"1 nap múlva öntözés"]);
        }
    }
}
