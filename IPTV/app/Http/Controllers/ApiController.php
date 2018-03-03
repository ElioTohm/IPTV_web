<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\Client;
use App\Device;
use App\User;
use App\oAuthClient;
use App\AppSettings;
use GuzzleHttp\Client as GuzzleClient;
use App\Purchase;
use App\Movie;

class ApiController extends Controller
{
    /** 
     * Function making it easier on the client to register device
     * Code will take the ID oc authclient and first 4 character of the secret
     * The function will check if there is a secret for the client starting 
     * with the first 4 character sent
     * The function will make an auth request to passport or return 401 respectively 
     */
    public function register(Request $request) 
    {
        // take request param
        $id = $request->query('id');
        $sentsecret = $request->query('secret');
        
        $device = Device::where('room', $id)->first();
        $oauthclient = oAuthClient::where('id', $device->id)
                                    ->where('revoked', 0)
                                    ->where('assigned_to', 0)
                                    ->first();

        if ($oauthclient != null) {
            $secret = $oauthclient->secret;
            $result = substr($secret, 0, 4);

            if (strcmp($result, $sentsecret) == 0 ) {
                $user = User::find(1);
                
                // $token = $user->createToken($oauthclient->name);
                $guzzle = new \GuzzleHttp\Client;
                
                $authrequest = $guzzle->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => $id,
                        'client_secret' => $oauthclient->secret,
                        'username' => 'admin@admin.com',
                        'password' => '123123',
                        'scope' => '',
                    ],
                ]);
                
                $response = json_decode((string) $authrequest->getBody(), true);
                $oauthclient->assigned_to = 1;
                $oauthclient->save();
                return response()->json([
                    'id' => $device->id,
                    'token_type' => $response['token_type'],
                    'expires_in' => $response['expires_in'],
                    'access_token' => $response['access_token'],
                    'refresh_token' => $response['refresh_token']
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
        $channels = Channel::with('genres', 'stream')->get();
        //'thumbnail' => env('APP_URL', 'localhost') . "/images/device/channels/" . urlencode($channel->thumbnail),
        return $channels;
    }

    // Get Movies 
    public function getVODStreams (Request $request)
    {
        $movies = Movie::with('genres', 'stream')->get();
        return response()->json($movies);
    }

    // Get Client Info
    public function getClientInfo (Request $request)
    {
        $device = Device::where('id', $request->input('id'))->first(['room']);

        $client = Client::where('room', $device->room)->with("purchases")->first();
        
        return response()->json($client);
        return response()->json([
            "id" => $client->id, 
            "name" => $client->name, 
            "email" => $client->email, 
            "room" => $client->room, 
            "welcome_message" => $client->welcome_message, 
            "welcome_image" => env('APP_URL', 'localhost') . "/images/device/welcome/" . urlencode($client->welcome_image), 
            "credit" => $client->credit, 
            "debit" => $client->debit
        ]);
    }

    // check for launcher app update
    public function launcherUpdateCheck (Request $request)
    {
        $enduserapp = AppSettings::where('app', 'launcher')->first();

        if ($request->get('version') < $enduserapp->version) {
            return response()->download(storage_path('app/private/apk/' . $enduserapp->apk_path),
                                        $enduserapp->apk_path, 
                                        ['Content-Type' => 'application/octet-stream']);
        } else {
            return NULL;
        }
    }

    public function clientPurchase (Request $request)
    {
        
        $client = Client::find($request->input('client_id'));
        $purchases = $request->input('purchases');

        foreach ($purchases as $purchase) {
            if ($purchase['purchasable_type'] == "Channel") {
                $channel = Channel::where("number", $purchase['purchasable_id'])->first();
                $purchase =  new Purchase();
                $purchase->client_id = $client->id;
                $channel->purachse()->save($purchase);
            }
        }

        return response()->json($client->with("purchases")->first());        
    }
    // unused
    // stream controller 
    public function streamFile ()
    {
        $fs = Storage::getDriver();
        $stream = $fs->readStream($file->path);

        return response()->stream(
            function() use($stream) {
                fpassthru($stream);
            }, 
            200,
            [
                'Content-Type' => $file->mime,
                'Content-disposition' => 'attachment; filename="'.$file->original_name.'"',
            ]);
    }
}
