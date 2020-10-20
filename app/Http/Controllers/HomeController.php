<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\BlackListedClient;
use App\Traits\UserActivity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const STATUS  = [
        'blacklist' => 1,
        'unblacklist' => 0
    ];

    use UserActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getClients()
    {
        return BlackListedClient::all();
    }
    public function getActivites()
    {
        return \App\UserActivity::all();
    }

    public function changeStatus(Request $request)
    {
        try {
            $client = BlackListedClient::find($request->id);
            if (self::STATUS[$request->status] == 1) {
                $client->status =   self::STATUS[$request->status];
                $client->date = Carbon::now();
                $client->save();
            } else {
                $client->status =   self::STATUS[$request->status];
                $client->date = null;
                $client->save();
            }
            $this->saveUserActivity("changed client record status to " . $request->status . "ed");
            return response()->json([
                'message' => "New client was " . $request->status . "ed",
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

    public function updateClient(Request $request)
    {
        try {
            $client = BlackListedClient::find($request->id);
            $client->update($request->all());
            $this->saveUserActivity("Updated client record [" . ucfirst($client->accountName) . "]");
            return response()->json([
                'message' => "New client was updated",
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

    public function deleteClients(Request $request)
    {
        try {
            foreach ($request->all() as $item) {
                BlackListedClient::destroy($item['id']);
                $this->saveUserActivity("Delected client records ");
                return response()->json([
                    'message' => "New client was deleted",
                    'position' => "top",
                    "type" => "success",
                    "status" => 204
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'position' => "top",
                "type" => "error"
            ]);
        }
    }

    public function deleteClient(Request $request)
    {
        try {
            BlackListedClient::destroy($request->id);
            $this->saveUserActivity("Delected a client record ");
            return response()->json([
                'message' => "New client was deleted",
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



    public function saveClient(Request $request)
    {
        try {
            BlackListedClient::create($request->all());
            $this->saveUserActivity("Created  a new client record");
            return response()->json([
                'message' => "New client was created",
                'position' => "top",
                "type" => "success",
                "status" => 201
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
