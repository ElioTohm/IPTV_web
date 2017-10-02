<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\oAuthClient;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ClientNotificationRequest;
use App\Events\NotificationEvent;

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

    public function sendNotification ($id, ClientNotificationRequest $request) 
    {
        $default_welcome_image = 'http://images.kuoni.co.uk/73/dubai-37075265-1494255242-ImageGalleryLightboxLarge.jpg';
        $message = $request->input('message');
        $image = $request->input('image');
        $type = $request->input('type');
        
        event(new NotificationEvent($id, ($type == '') ? 0 : $type,
                                        ($message == '') ? 'Welcome' : $message, 
                                        ($image == '') ? $default_welcome_image : $image));
    }
}
