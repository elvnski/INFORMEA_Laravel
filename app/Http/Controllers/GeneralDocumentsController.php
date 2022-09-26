<?php

namespace App\Http\Controllers;

use App\Models\General_documents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  GeneralDocumentsController extends Controller{

    //create and update General documents
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importGeneralDocuments(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/83d86625-98d5-4c68-9bde-588729a35184/items/";
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
                if($value['key'] == "dc.identifier.uri"){
                    $identifier_uri = $value['value'];
                }
                if($value['key'] == "dc.language.iso"){
                    $language = $value['value'];
                }
                if($value['key'] == "dc.title"){
                    $title = $value['value'];
                }
            }

                $new_generaldocuments = General_documents::create([ 
                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                'date_issued'                   =>  $date_issued,
                'identifier_uri'                =>  $identifier_uri,
                'language'                      =>  $language,
                'title'                         =>  $title,
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update General documents details
    
    public function updateGeneralDocuments(Request $request, $id){
        $general_documents = General_documents::find($id);
        $general_documents->collection = $request->input('collection');
        $general_documents->uuid =  $request->input('uuid');
        $general_documents->handle = $request->input('handle');
        $general_documents->link = $request->input('link');
        $general_documents->numberitems = $request->input('numberitems');
        $general_documents->save();
        return response()->json($general_documents);
    }


    //view general documents
    public function viewGeneralDocuments($id){
        $general_documents =  General_documents::find($id);
            return response()->json($general_documents);
    }


    //delete general documents(
    public function deleteGeneralDocuments($id){
        $general_documents =  General_documents::find($id);
        $general_documents->delete();

        return response()->json('Removed successfully');
    }

    //list General Documents
    public function index(){
        $general_documents["data"] = General_documents::limit(10)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($general_documents);
    }

} 
?>