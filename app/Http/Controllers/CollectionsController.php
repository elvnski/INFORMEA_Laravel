<?php

namespace App\Http\Controllers;

use App\Models\Collections;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  CollectionsController extends Controller{

    //create and update collection if existing
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importCollections(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/communities/56376410-01ba-4797-a275-be23f50eb61d/communities";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
            $link = "https://wedocs.unep.org".$d['link']."/collections";
            $data2[]= [
                'link'=> $link,
                ];

                $result_data =  $this->fetchFromUrl($link);

                foreach($result_data as $key){

                    if($key['name'] !== "Meetings"){

                        $data3[]= [
                            'name'=> $key['name'],
                            'uuid'=> $key['uuid'],
                            'handle'=> $key['handle'],
                            'link'=> $key['link'],
                            'numberItems'=> $key['numberItems'],
                        ];
        

                    }
                
                    
                }
            }

        $response['data']= $data3;

        foreach($response['data'] as $row)
        {
            
         $existing_collection = Collections::where('uuid', $row['uuid'])->first();
         if($existing_collection){
            $updated_collection = Collections::find($existing_collection->id)->update(
            [
                'collection'        => $row["name"],
                'handle'            => $row["handle"],
                'link'              => $row["link"],
                'numberitems'       => $row["numberItems"],
            ]
            );
         }
         else{
            $new_collection = Collections::create([ 'collection'        => $row["name"],
                                                    'uuid'              => $row["uuid"],
                                                    'handle'            => $row["handle"],
                                                    'link'              => $row["link"],
                                                    'numberitems'       => $row["numberItems"],
                                            
            ]);
        }
        }

            $final_data[]= $response;

            $response['data'] = $final_data;

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        //return response()->json('Added successfully');
        return response()->json($response);

    }
    
    //update collection details
    
    public function updateCollection(Request $request, $id){
        $collections = Collection::find($id);
        $collections->collection = $request->input('collection');
        $collections->uuid =  $request->input('uuid');
        $collections->handle = $request->input('handle');
        $collections->link = $request->input('link');
        $collections->numberitems = $request->input('numberitems');
        $collections->save();
        return response()->json($collections);
    }


    //view collection
    public function viewCollection($id){
     $collections =  Collections::find($id);
            return response()->json($collections);
    }


    //delete collection(
    public function deleteCollection($id){
        $collections =  Collections::find($id);
        $collections->delete();

        return response()->json('Removed successfully');
    }

    //list collections
    public function index(){

        $collections['totalItems'] = Collections::all()->count();
        $collections['data'] = Collections::all();

        $per_page = isset($_GET['_limit']) && is_numeric($_GET['_limit']) ? $_GET['_limit'] : 10;
        $offset = isset($_GET['_page']) && is_numeric($_GET['_page']) ? $_GET['_page'] : 1;
        $offset = ($offset - 1) * $per_page;
       
        
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($collections);
    }

} 
?>