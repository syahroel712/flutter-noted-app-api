<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FolderModel;
use Illuminate\Support\Facades\Validator;
use DB;

class FolderController extends Controller
{
    public function index()
    {
        $folders = FolderModel::all();
        return response()->json([
            "success" => true,
            "message" => "Folder List",
            "data" => $folders
        ], 200);
    }

    public function store(Request $request, FolderModel $folder)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'folder_nama' => 'required',
            'folder_status' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ], 422);      
        }

        $folder->user_id = $request->user_id;
        $folder->folder_nama = $request->folder_nama;
        $folder->folder_status = $request->folder_status;
        $folder->save();

        return response()->json([
            "success" => true,
            "message" => "Folder created successfully",
            "data" => $folder
        ], 201);
    }

    public function show($id)
    {
        $folder = FolderModel::find($id);

        if(is_null($folder)){
            return response()->json([
                "success" => false,
                "message" => "Folder not found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Folder retrieved succesfully",
            "data" => $folder,
        ], 200);
    }

    public function update(Request $request, FolderModel $folder)   
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'folder_nama' => 'required',
            'folder_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ], 422);
        }

        $folder->user_id = $request->user_id;
        $folder->folder_nama = $request->folder_nama;
        $folder->folder_status = $request->folder_status;
        $folder->save();
        
        return response()->json([
            "success" => true,
            "message" => "Folder updated successfully",
            "data" => $folder
        ], 201);
    }

    public function destroy(FolderModel $folder)
    {
        $folder->delete();
        
        return response()->json([
            "success" => true,
            "message" => "Folder deleted successfully"
        ], 200);
    }

}
