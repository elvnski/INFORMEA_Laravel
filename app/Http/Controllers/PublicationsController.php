<?php

namespace App\Http\Controllers;

use App\Models\Publications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  PublicationsController extends Controller{

    //create and update publications
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importPublications(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/9aa4daaa-d19f-42ba-a596-32612aefd7dd/items/";
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
                    
                    if($value['key'] == "dc.date.accessioned"){
                        $date_accessioned = $value['value'];
                    }
                    if($value['key'] == "dc.date.available"){
                        $date_available = $value['value'];
                    }
                    if($value['key'] == "dc.date.issued"){
                        $date_issued = $value['value'];
                    }
                    if($value['key'] == "dc.identifier"){
                        $identifier = $value['value'];
                    }
                    if($value['key'] == "dc.identifier.uri"){
                        $identifier_uri = $value['value'];
                    }
                    if($value['key'] == "dc.publisher"){
                        $publisher = $value['value'];
                    }
                    if($value['key'] == "dc.title"){
                        $title = $value['value'];
                    }
                    if($value['key'] == "dc.type"){
                        $type = $value['value'];
                    }
                }


                // var_dump($date);
                // exit;

                $new_publications = Publications::create([ 

                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                'date_issued'                   =>  $date_issued,
                'identifier'                    =>  $identifier,
                'identifier_uri'                =>  $identifier_uri,
                'publisher'                     =>  $publisher,
                'title'                         =>  $title,
                'type'                          =>  $type,
        
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
       

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update publications details
    
    public function updatePublications(Request $request, $id){
        $publications = Publications::find($id);
        $publications->collection = $request->input('collection');
        $publications->uuid =  $request->input('uuid');
        $publications->handle = $request->input('handle');
        $publications->link = $request->input('link');
        $publications->numberitems = $request->input('numberitems');
        $publications->save();
        return response()->json($publications);
    }


    //view publications
    public function viewPublications($id){
        $publications =  Publications::find($id);
            return response()->json($publications);
    }


    //delete publications(
    public function deletePublications($id){
        $publications =  Publications::find($id);
        $publications->delete();

        return response()->json('Removed successfully');
    }

    //list publications
    public function index(){
        $publications["data"] = Publications::limit(10)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($publications);
    }

} 
?>