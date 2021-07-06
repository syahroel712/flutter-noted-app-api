<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NoteModel;
use Illuminate\Support\Facades\Validator;
use DB;

class NoteController extends Controller
{
    public function index()
    {
        $notes = DB::table('tb_note')
                ->where('note_status', 'Active')
                ->get();
        
        return response()->json([
            "success" => true,
            "message" => "Note List",
            "data" => $notes,
        ]);
    }

    public function store(Request $request, NoteModel $note)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'folder_id' => 'required',
            'note_title' => 'required',
            'note_desc' => 'required',
            'note_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ]);
        }

        $note->user_id = $request->user_id;
        $note->folder_id = $request->folder_id;
        $note->note_title = $request->note_title;
        $note->note_desc = $request->note_desc;
        $note->note_status = $request->note_status;
        $note->save();

        return response()->json([
            "success" => true,
            "message" => "Note created successfully",
            "data" => $note
        ]);
    }

    public function show($id)
    {
        $note = NoteModel::find($id);

        if(is_null($note)){
            return response()->json([
                "success" => false,
                "message" => "Note not found"
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Note retrieved successfully",
            "data" => $note,
        ]);
    }


    public function update(Request $request, NoteModel $note)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'folder_id' => 'required',
            'note_title' => 'required',
            'note_desc' => 'required',
            'note_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => "The given data was invalid",
                "data" => $validator->messages(),
            ]);
        }

        $note->user_id = $request->user_id;
        $note->folder_id = $request->folder_id;
        $note->note_title = $request->note_title;
        $note->note_desc = $request->note_desc;
        $note->note_status = $request->note_status;
        $note->save();

        return response()->json([
            "success" => true,
            "message" => "Note updated successfully",
            "data" => $note
        ]);
    }

    public function destroy(NoteModel $note)
    {
        $note->delete();

        return response()->json([
            "success" => true,
            "message" => "Note deleted succesfully"
        ]);
    }

}
