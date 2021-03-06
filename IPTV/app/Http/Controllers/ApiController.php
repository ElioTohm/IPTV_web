<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\Client;
use App\Device;
use App\User;
use App\oAuthClient;
use GuzzleHttp\Client as GuzzleClient;

class ApiController extends Controller
{
    /** 
     * Function making it easier on the client to register device
     * Code will take the ID oc authclient and first 4 character of the secret
     * The function will check if there is a secret for the client starting 
     * with the first 4 character sent
     * The function will make an auth request to passport or return 401 respectively 
     */
    public function register(Request $request) {
        // take request param
        $id = $request->query('id');
        $sentsecret = $request->query('secret');
        
        $device = Device::where('room', $id)->first();
        $oauthclient = oAuthClient::where('id', $device->id)
                                    ->where('revoked', 0)
                                    ->first();

        if ($oauthclient != null){
            $secret = $oauthclient->secret;
            $result = substr($secret, 0, 4);

            if (strcmp($result, $sentsecret) == 0 ){
                $user = User::find(1);

                $token = $user->createToken($oauthclient->name);
                
                return response()->json([
                    'id' => $device->id,
                    'token_type' => 'Bearer',
                    'expires_in' => $token->token->expires_at,
                    'access_token' => $token->accessToken
                ]);
            }
        }

        return response()->json([
                    'error' => 401,
                ]);

        
    }

    // Get Channels
    public function getChannel (Request $request) 
    {
        $channels = Channel::with('genres')->get(['id', 'number', 'name', 'stream', 'thumbnail']);
        $result = [];
        foreach ($channels as $key => $channel) {
            array_push($result, [
                'id' => $channel->id, 
                'number' => $channel->number, 
                'name' => $channel->name, 
                'stream' => $channel->stream, 
                'thumbnail' => env('APP_URL', 'localhost') . "/images/device/channels/" . rawurldecode($channel->thumbnail),
                'genres' => $channel->genres
            ]);
        }
        return $result;
    }

    // Get Client Info
    public function getClientInfo (Request $request)
    {
        $device = Device::where('id', $request->input('id'))->first(['room']);

        $client = Client::where('room', $device->room)->first(["id", "name", "email", "room", "welcome_message", "welcome_image", "credit", "debit"]);
        
        // return $client;
        return response()->json([
            "id" => $client->id, 
            "name" => $client->name, 
            "email" => $client->email, 
            "room" => $client->room, 
            "welcome_message" => $client->welcome_message, 
            "welcome_image" => env('APP_URL', 'localhost') . "/images/device/welcome/" . rawurldecode($client->welcome_image), 
            "credit" => $client->credit, 
            "debit" => $client->debit
        ]);
    }
}
