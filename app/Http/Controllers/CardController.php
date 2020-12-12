<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use Spatie\DbDumper\DbDumper;

class CardController extends Controller
{
    public function exportDB()
    {
            try {
                \Spatie\DbDumper\Databases\MySql::create()
                ->setDbName("trello")
                ->setUserName("root")
                ->setPassword("")
                ->dumpToFile('trello_boards.sql');
                return response()->json([
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
   
    public function index()
    {
        try {
            return response()->json([
                'records' =>  Card::all(),
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
        
    }

    public function store(Request $request)
    {
        try {
            Card::create(['title' =>$request->title, 'description'=>$request->description , 'columnId' => $request->columnId]);
            return response()->json([
                'message' => "New card was created",
                'new_record' => Card::latest()->first(),
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
            $column =  Card::findOrFail($id)->first();
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
            Card::find($id)->update(['title' =>$request->title , 'description' => $request->description]);
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
            $column =  Card::destroy($id);
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
