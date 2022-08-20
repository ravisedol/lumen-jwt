<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Crud;

class CrudController extends Controller
{
    


    // List
    public function index(){

        $data = Crud::orderBy('id','desc')->paginate(10);

        if($data->isNotEmpty()){

            return response()->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $data
            ],200);

        }

        return response()->json([
            'status' => 0,
            'message' => 'Data Not Found',
        ],403);

    }




    // Store
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cruds',
            'country' => 'required|string',
            'address' => 'required',
        ]);

        if($validator->fails()){
            
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toJson()
            ],200);
        }

        $data = Crud::insert([
            'name' => $request->name,
            'country' => $request->country,
            'address' => $request->address
        ]);

        if($data){

            return response()->json([
                'status' => 1,
                'message' => 'Created Successfully'
            ],201);

        }

        return response()->json([
            'status' => 0,
            'message' => 'Oops something went wrong!'
        ],403);

    }


    // Get by id
    public function details(Request $request){

        $id = $request->id;

        if(isset($id)){

            $data = Crud::find($id);

            if($data){
                return response()->json([
                    'status' => 1,
                    'message' => 'Success',
                    'data' => $data
                ],200);
            } 
    
            return response()->json([
                'status' => 0,
                'message' => 'Data not found'
            ],200);
            
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalid'
        ],200);

    }


    // Update
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'country' => 'required|string',
            'address' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $id = $request->id;

        $data = Crud::find($id)->update([
            'name' => $request->name,
            'country' => $request->country,
            'address' => $request->address
        ]);

        if($data){

            return response()->json([
                'status' => 1,
                'message' => 'Updated Successfully'
            ],200);

        }

        return response()->json([
            'status' => 0,
            'message' => 'Oops something went wrong!'
        ],403);

    }


    // Delete
    public function delete($id=null){

        // $id = $request->id;

        $data = Crud::find($id)->delete();

        if($data){

            return response()->json([
                'status' => 1,
                'message' => 'Deleted Successfully'
            ],200);

        }

        return response()->json([
            'status' => 0,
            'message' => 'Oops something went wrong!'
        ],403);

    }


}
