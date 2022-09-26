<?php

namespace App\Http\Controllers;

use App\Models\Country_reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  CountryReportsController extends Controller{

    //create and update country reports
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importCountryReports(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/71ab5219-5355-46fc-bb02-23aa84f9d50c/items/";
        $final_data = [];
        
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
            $link = "https://wedocs.unep.org".$d['link']."/metadata";
                $data2[]= [
                'link'=> $link,
                ];
                $result_data =  $this->fetchFromUrl($link);

                foreach($result_data as $key => $value){
                    
                    if($value['key'] == "dc.contributor.author"){
                        $author = $value['value'];
                    }
                    if($value['key'] == "dc.date.accessioned"){
                        $date_accessioned = $value['value'];
                    }
                    if($value['key'] == "dc.date.available"){
                        $date_available = $value['value'];
                    }
                    if($value['key'] == "dc.date.issued"){
                        $date_issued = $value['value'];
                    }
                    if($value['key'] == "dc.identifier.uri"){
                        $uri = $value['value'];
                    }
                    if($value['key'] == "dc.description"){
                        $description = $value['value'];
                    }
                    if($value['key'] == "dc.language"){
                        $language = $value['value'];
                    }
                    if($value['key'] == "dc.publisher"){
                        $publisher = $value['value'];
                    }
                    if($value['key'] == "dc.subject"){
                        $subject = $value['value'];
                    }
                    if($value['key'] == "dc.title"){
                        $title = $value['value'];
                    }
                    if($value['key'] == "dc.type"){
                        $type = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.country"){
                        $country = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.rights"){
                        $rights = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.treaty"){
                        $treaty = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.url"){
                        $url = $value['value'];
                    }
                }


                // var_dump($date_accessioned);
                // exit;

                $new_countryreports = Country_reports::create([ 
                'author'                        =>  $author,
                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                'date_issued'                   =>  $date_issued,
                'uri'                           =>  $uri,
                'description'                   =>  $description,
                'language'                      =>  $language,
                'publisher'                     =>  $publisher,
                'subject'                       =>  $subject,
                'title'                         =>  $title,
                'type'                          =>  $type,
                'country'                       =>  $country,
                'rights'                        =>  $rights,
                'treaty'                        =>  $treaty,
                'url'                           =>  $url,
        
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update country Reports details
    
    public function updateCountryReports(Request $request, $id){
        $country_reports = Country_reports::find($id);
        $country_reports->collection = $request->input('collection');
        $country_reports->uuid =  $request->input('uuid');
        $country_reports->handle = $request->input('handle');
        $country_reports->link = $request->input('link');
        $country_reports->numberitems = $request->input('numberitems');
        $country_reports->save();
        return response()->json($country_reports);
    }


    //view country Reports
    public function viewCountryReports($id){
        $country_reports =  Country_reports::find($id);
            return response()->json($country_reports);
    }


    //delete country Reports(
    public function deleteCountryReports($id){
        $country_reports =  Country_reports::find($id);
        $country_reports->delete();

        return response()->json('Removed successfully');
    }

    //list country Reports
    public function index(){
        $country_reports["data"] =Country_reports::all();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($country_reports);
    }

} 
?>