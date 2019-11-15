<?php

/**
 * SBN 
 *
 * - 
 *
 * @category            
 * @package             
 * @subpackage             
 * @author              
 * @copyright           SBN
 * @license             http://
 * @link                http://www.
 * @since               Version 0.1
 * @version             Version 0.1
 * @filesource
 
 * Coutries information
 * @link               https://github.com/antonioribeiro/countries

 */

// ------------------------------------------------------------------------

use Illuminate\Database\Seeder;

use App\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		/*
			Importing data in json format
		*/
		DB::table('countries')->delete();
        // $json = File::get("database/data/all_countries.json");
        $json = File::get(storage_path("app/public/all_countries.json"));
        // $data = json_decode($json,true);
        $data = json_decode($json);

		foreach ($data as $obj) {
			// Validates the existance of the required Values
			// in the json structure
			try {
				$db_record = array (

				'ccn3' => $obj->iso_3166_1_numeric,
				'cca3' => $obj->iso_3166_1_alpha3,
				'cca2' => $obj->iso_3166_1_alpha2,
				
				'name' => $obj->name->common,
				'full_name' => $obj->name->official,
				
				'capital' => $obj->capital[0],

				'region' => $obj->geo->region,
				'region_code' => $obj->geo->region_code,
				'subregion' => $obj->geo->subregion,
				'subregion_code' => $obj->geo->subregion_code,
				
				'created_by' => 1,
				'last_update_by' => 1,
				
				);
			} catch(exception $ex) {
				echo $ex->getMessage() . "\n";
				echo $obj->name->common . "\n";
			}
			
			// Validates the correct execution of the query
			try {
				Country::create($db_record);
			} catch(exception $ex) {
				echo $ex->getMessage() . "\n";
			}
			
		}
		
    }
}
