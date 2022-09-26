<?php

namespace App\Http\Controllers;

use App\Models\Meetings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  MeetingsController extends Controller{

    //create and update meetings
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importMeetings(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/5e464e1f-0150-4c68-a957-497c83d1d80a/items/";
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
                        $identifier_uri = $value['value'];
                    }
                    if($value['key'] == "dc.description"){
                        $description = $value['value'];
                    }
                    if($value['key'] == "dc.language"){
                        $language = $value['value'];
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
                    if($value['key'] == "informea.identifier.city"){
                        $city = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.country"){
                        $country = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.date-end"){
                        $date_end = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.date-start"){
                        $date_start = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.latitude"){
                        $latitude = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.longitude"){
                        $longitude = $value['value'];
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
                }
    


                // var_dump($date_accessioned);
                // exit;

                $new_meetings = Meetings::create([ 
                'author'                        =>  $author,
                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                //'date_issued'                   =>  $date_issued,
                'identifier_uri'                =>  $identifier_uri,
                //'uri'                           =>  $uri,
                'description'                   =>  $description,
                'language'                      =>  $language,
                'subject'                       =>  $subject,
                'title'                         =>  $title,
                'type'                          =>  $type,
                //'category'                      =>  $category,
                'date_start'                    =>  $date_start,
                'date_end'                      =>  $date_end,
                //'document_code'                 =>  $document_code,
                //'document_title'                =>  $document_title,
                'latitude'                      =>  $latitude,
                'longitude'                     =>  $longitude,
                'rights'                        =>  $rights,
                'status'                        =>  $status,
                'treaty'                        =>  $treaty,
                'url'                           =>  $url,
                'city'                          =>  $city,
                'country'                       =>  $country,
        
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update contacts details
    
    public function updateMeetings(Request $request, $id){
        $meetings = Meetings::find($id);
        $meetings->collection = $request->input('collection');
        $meetings->uuid =  $request->input('uuid');
        $meetings->handle = $request->input('handle');
        $meetings->link = $request->input('link');
        $meetings->numberitems = $request->input('numberitems');
        $meetings->save();
        return response()->json($meetings);
    }


    //view contacts
    public function viewMeetings($id){
     $meetings =  Meetings::find($id);
            return response()->json($meetings);
    }


    //delete contacts(
    public function deleteMeetings($id){
        $meetings =  Meetings::find($id);
        $meetings->delete();

        return response()->json('Removed successfully');
    }

    //list contacts
    public function index(){
        $meetings["data"] = Meetings::limit(15)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($meetings);
    }

} 
?>