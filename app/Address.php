<?php

namespace App;

use App\Helpers\TaiwanDistrict;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    
    /**
     * 存資料到資料表Address
     * @param Request $request
     * @return Address
     */
    public static function insert_row(Request $request){
        
        $address = new Address();
        if($user = $request->user()){
            $address->user_id = $user->id;
        }

        $address->country_id = $request->country_id;
        $address->name = $request->name;
        
        $address->county = $request->county;
        $address->postal_code = $request->postal_code;
        $address->city = TaiwanDistrict::getCityName($request->county,$request->postal_code);

        $address->address1 = $request->address1;
        
        $address->phone = $request->phone;
        $address->mobile_phone = $request->mobile_phone;

        $address->save();

        return $address;

    }

}
