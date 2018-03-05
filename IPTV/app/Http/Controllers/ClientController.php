<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\oAuthClient;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ClientNotificationRequest;
use Intervention\Image\ImageManagerStatic as Image;
use App\Events\NotificationEvent;

class ClientController extends Controller
{
    public function getClients (Request $request) 
    {
        if ($request->exists('filter')) {
            $pagination = Client::search($request->input('filter'))->paginate(env('ITEM_PER_PAGE'));
            
        } else {
            $query = Client::with('purchases.purchasable');
            // handle sort option
            if ($request->has('sort')) {
                // handle multisort
                $sorts = explode(',', $request->sort);
                foreach ($sorts as $sort) {
                    list($sortCol, $sortDir) = explode('|', $sort);
                    $query = $query->orderBy($sortCol, $sortDir);
                }
            } else {
                $query = $query->orderBy('name', 'asc');
            }
            $pagination = $query->paginate(env('ITEM_PER_PAGE'));
        }

        $pagination->appends([
            'sort' => $request->sort,
            'filter' => $request->filter,
            'per_page' => $request->per_page
        ]);

        return response()->json(
                $pagination
        );
    }

    
    public function addClient (ClientRequest $request) 
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->room = $request->input('room');
        if ($request->input('welcome_message') !== NULL && $request->input('welcome_message') != '') {
            $client->welcome_message = $request->input('welcome_message');
        }
        // if ($request->get('welcome_image') !== NULL && $request->get('welcome_message') != '') {
        //     $client->welcome_image = $request->input('welcome_image');
        // }
        $client->balance = $request->input('balance');
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
        // $this->checkWeclomeImage ($client, $request->get('welcome_image'), $request->input('room'), FALSE);        
        $client->balance = $request->input('balance');
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
        return response()->json([
            'sent' => 1
        ]); 
    }

    private function checkWeclomeImage ($client, $image, $room, $addclient) {
        if (substr( $image, 0, 10 ) === "data:image") {
            // apply filter
            Image::make($image)->encode('png', 50)->save(public_path('images/device/welcome') . $room . '.png');
            $client->welcome_image = 'Welcome_' . $room . '.png';
        }
    }

}
