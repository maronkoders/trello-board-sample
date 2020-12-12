<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Column;
use App\Card;
class ColumnController extends Controller
{
    
    public function index()
    {
        try {
            return response()->json([
                'records' =>  Column::all(),
                'position' => "top",
                "type" => "success",
                "status" => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        try {
            Column::create(['title' =>$request->title]);
            return response()->json([
                'message' => "New column was updated",
                'new_record' => Column::latest()->first(),
                'position' => "top",
                "type" => "success",
                "status" => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }

    public function show($id)
    {
        try {
            $column =  Column::findOrFail($id)->first();
            return response()->json([
                'column' => $column,
                'position' => "top",
                "type" => "success",
                "status" => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }

    
    public function edit($id)
    {
      
    }

   
    public function update(Request $request, $id)
    {
        try {
            Column::find($id)->update(['title' =>$request->title]);
            return response()->json([
                'message' => "A record was updated",
                'position' => "top",
                "type" => "success",
                "status" => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }

   
    public function destroy($id)
    {
        try {
            $card = Card::where("columnId",$id)->delete();
            $column =  Column::destroy($id);
            return response()->json([
                'Message' => "Record was destroyed",
                'position' => "top",
                "type" => "success",
                "status" => 204
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }
}
