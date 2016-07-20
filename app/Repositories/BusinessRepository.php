<?php

namespace App\Repositories;

use App\Models\Business;

class BusinessRepository{
    
    /**
    * Get all businesses that are not 'deleted'
    * @return Array<Array<string>> with all non deleted Businesses
    */
    public static function getAll(){
        return Business::all();
    }

    /**
    * Stores a new Business to the database
    * @param Array<string>  $business The new business to be stored to the database
    * @return bool  true if the business was stored correctly, false if not
    */
    public static function create($business){
        $dbBusiness = new Business;

        $dbBusiness->name = $business['name'];
        $dbBusiness->description = $business['description'];
        $dbBusiness->lat = $business['lat'];
        $dbBusiness->long = $business['long'];
        $dbBusiness->created_at = date('Y-m-d H:i:s');

        if($dbBusiness->save()){
            return $dbBusiness->toArray();
        }
        return false;
    }

    /**
    * Stores a new Business to the database
    * @param Array<string>  $business The new data business to be updated in the database
    * @param int $id Representing the identifier of the business 
    * @return bool  true if the business was updated correctly, false if not
    */
    public static function update($business, $id){
        $dbBusiness = Business::find($id);
        if(!$dbBusiness){
            return false;
        }
        $dbBusiness->name = $business['name'];
        $dbBusiness->description = $business['description'];
        $dbBusiness->lat = $business['lat'];
        $dbBusiness->long = $business['long'];
        $dbBusiness->updated_at = date('Y-m-d H:i:s');

        if($dbBusiness->save()){
            return $dbBusiness->toArray();
        }
        return false;
    }

    /**
    * Finds a business by its id
    * @param int $id  Representing the identifier of the business
    * @returnArray<string> With the data of the business, false if business not found
    */
    public static function findById($id){
        $business = Business::find($id);
        if($business){
            return $business->toArray();
        }
        return false;
    }

    /**
    * Deletes a business by its id
    * @param int $id  Representing the identifier of the business
    * @return  bool  true if the business was deleted correctly, false if not
    */
    public static function delete($id){
        return Business::where('id','=',$id)->delete();
        if(!$dbBusiness){
            return false;
        }

        return true;
    }
}
