<?php

namespace App\Http\Controllers;

use App\Models\Decisions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  DecisionsController extends Controller{

    //create and update decisions
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importDecisions(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/f07c193c-98b5-48e9-91a9-df4099c68242/items";
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
                    if($value['key'] == "informea.identifier.display-order"){
                        $display_order = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.meeting-id"){
                        $meeting_id = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.number"){
                        $number = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.rights"){
                        $rights = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.status"){
                        $status = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.treaty"){
                        $treaty = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.url"){
                        $url = $value['value'];
                    }
                }

                // var_dump($title);
                // exit;

                $new_decision = Decisions::create([ 
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
                'display-order'                 =>  $display_order,
                'meeting-id'                    =>  $meeting_id,
                'number'                        =>  $number,
                'rights'                        =>  $rights,
                'status'                        =>  $status,
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
    
    //update decisions details
    
    public function updateDecisions(Request $request, $id){
        $decisions = Decisions::find($id);
        $decisions->collection = $request->input('collection');
        $decisions->uuid =  $request->input('uuid');
        $decisions->handle = $request->input('handle');
        $decisions->link = $request->input('link');
        $decisions->numberitems = $request->input('numberitems');
        $decisions->save();
        return response()->json($decisions);
    }


    //view decisions
    public function viewDecisions($id){
        $decisions =  Decisions::find($id);
            return response()->json($decisions);
    }


    //delete decisions(
    public function deleteDecisions($id){
        $decisions =  Decisions::find($id);
        $decisions->delete();

        return response()->json('Removed successfully');
    }

    //list contacts
    public function index(){
        $decisions["data"] = Decisions::limit(10)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($decisions);
    }

} 
?>