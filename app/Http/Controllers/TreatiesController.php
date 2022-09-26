<?php

namespace App\Http\Controllers;

use App\Models\Treaties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  TreatiesController extends Controller{

    //create and update treaties
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importTreaties(Request $request){
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
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        // foreach($result_data as $temp){
        //     $data3[]=[
        //         'key'=> $temp['key'],
        //         'value'=> $temp['value'],
        //     ];
        //     $response['data'] = $data3;
        // }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update treaties details
    
    public function updateTreaties(Request $request, $id){
        $treaties = Treaties::find($id);
        $treaties->collection = $request->input('collection');
        $treaties->uuid =  $request->input('uuid');
        $treaties->handle = $request->input('handle');
        $treaties->link = $request->input('link');
        $treaties->numberitems = $request->input('numberitems');
        $treaties->save();
        return response()->json($treaties);
    }


    //view treaties
    public function viewTreaties($id){
        $treaties =  Treaties::find($id);
            return response()->json($treaties);
    }


    //delete treaties(
    public function deleteTreaties($id){
        $treaties =  Treaties::find($id);
        $treaties->delete();

        return response()->json('Removed successfully');
    }

    //list treaties
    public function index(){
        $treaties = Treaties::all();
        return response()->json($treaties);
    }

} 
?>