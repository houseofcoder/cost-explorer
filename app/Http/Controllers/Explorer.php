<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CostType;
use App\Models\Client;
use App\Models\Project;
class Explorer extends Controller
{
    function search(Request $request)
    {
        // Get requested client ids
        $client_ids =[];
        if($request->has('client_id')) {
            $client_ids = $request->get('client_id');
        }
        
        // Get requested cost types details or All cost types
        $cost_type_ids = [];
        if($request->has('cost_type_id')) {
            $cost_type_ids = $request->get('cost_type_id');
            if(count($cost_type_ids) >0) {
                $cost_types = CostType::whereIn('id',$cost_type_ids)->get();
            }
        }
        else {
            $cost_types = CostType::all();
        }

        // Get requested project details or All projects
        $project_ids = [];
        if($request->has('project_id')) {
            $project_ids = $request->get('project_id');
            $projects = Project::whereIn('id',$project_ids)->get();
        }
        else {
            $projects = Project::all();
        }

        $response = $this->formatResponse( $projects, $client_ids, $cost_types);

        if(count($response) > 0) {
            return response()->json($response);
        }

        // Default response if no result found 
        return response()->json(['message' => 'No results'], 404);
    }

    private function formatResponse($projects, $client_ids, $cost_types) {
        $response = [];
        $client_data = [];
        if( $projects->count() > 0 ) {
            foreach($projects as $outter_key => $project) {

                // Get projects only for requested clients
                if( count($client_ids) > 0 && !in_array($project['client_id'],$client_ids)) {
                    $projects->forget($outter_key);
                    continue;
                }
    
                // Append Project childrens
                $project_child = [];
                foreach ( $project->cost as $inner_key => $value) {
                    if($cost_types->contains('id', $value->type->id)){
                        $project_child[] = [
                            "id"=> $value->type->id,
                            "name" => $value->type->name,
                            "amount"=> $value->amount,
                            "type"=> "cost",                        
                            "children"=>[],
                        ];
                    }                
                }
                    
                // Append client childrens
                $project['type']   = 'project';
                $project['name']   = $project['title'];
                $project['amount']   = collect($project_child)->sum('amount');            
                $project['children'] = $project_child;

                $client_id =  $project['client_id'];    
                if(isset($client_data[$client_id]))
                {
                    $client_data[$client_id]['amount'] += $project->amount;
                    array_push($client_data[$client_id]['children'],$project) ;
                }
                else
                {
                    $client_data[$client_id] = [
                        "id"=> $project->client->id,
                        "name"=> $project->client->name,
                        "type"=>"client",                    
                        "amount"=> $project->amount,                    
                        "children"=>[$project],
                    ];
                }

                // ---
                unset($projects[$outter_key]['cost'],$projects[$outter_key]['client']);
            }
            $response = collect($client_data)->sortBy('id')->values();
        }
        return $response;
    }
}
