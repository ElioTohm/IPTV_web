<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\oAuthClient;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    public function getClients () 
    {
        // fetch all clients with id
        $clients = Client::get();

        return response()->json([
            'clients' => $clients,
        ]);
    }

    
    public function addClient (ClientRequest $request) 
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->room = $request->input('room');
        $client->welcome_message = $request->input('welcome_message');
        $client->credit = $request->input('credit');
        $client->debit = $request->input('debit');
        $client->save();

        return $client;

    }

    public function updateClient ($id, ClientRequest $request) 
    {
        $client = Client::find($id);
        
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->room = $request->input('room');
        $client->welcome_message = $request->input('welcome_message');
        $client->credit = $request->input('credit');
        $client->debit = $request->input('debit');

        $client->save();

        return $client;
    }

    public function deleteClient ($id) 
    {
        $client = Client::find($id);
        $client->delete();

    }
}
