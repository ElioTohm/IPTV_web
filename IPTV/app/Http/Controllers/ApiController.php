<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
use App\Section;
use App\Service;

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
                                    ->where('registered', 0)
                                    ->first();

        if ($oauthclient != null) {
            $secret = $oauthclient->secret;
            $result = substr($secret, 0, 4);
            
            if (strcmp($result, $sentsecret) == 0 ) {
                // $user = User::find(1);
                
                // $token = $user->createToken($oauthclient->name);
                $guzzle = new \GuzzleHttp\Client;

                $user = new User();
                $user->name = 'Room ' . $id;
                $user->email = $id . '@dvb.com';
                $user->password = bcrypt(env('DEVICE_PASS'));
                $user->role = 4;
                $user->save();

                $authrequest = $guzzle->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => $oauthclient->id,
                        'client_secret' => $oauthclient->secret,
                        'username' => $user->email,
                        'password' => env('DEVICE_PASS'),
                        'scope' => '',
                    ],
                ]);
                
                $response = json_decode((string) $authrequest->getBody(), true);
                $oauthclient->registered = 1;
                $oauthclient->save();
                return response()->json([
                    'id' => $id,
                    'room' => 'Room '. $id,
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
        $channels = Channel::with('genres', 'stream')
            ->get()
            ->transform(function ($channel) {
                if ($channel->stream->catchup) {
                    $channel->stream->vid_stream = Storage::disk('catchup')->url('streams/'.$channel->stream->id.'/master.m3u8');
                    $channel->stream->type = 2;
                }

                $url = explode('/',$channel->thumbnail);
                $channel->thumbnail = Storage::disk('public_api')->url('channels/images/' . $url[sizeof($url) - 1]);
                return $channel;
            });
        return $channels;
    }

    // Get Movies 
    public function getVODStreams (Request $request)
    {
        $movies = Movie::with('genres', 'stream')
            ->get()
            ->transform(function ($movie) {
                if ($movie->stream->channel == NULL) {
                    $movie->stream->vid_stream = Storage::disk('vod')->url('movies/'.$movie->stream->vid_stream);
                }
                
                $url = explode('/',$movie->poster);
                $movie->poster = Storage::disk('public_api')->url('movies/images/' . $url[ sizeof($url) - 1]);
                return $movie;
            });
        return response()->json($movies);
    }

    // Get Client Info
    public function getClientInfo (Request $request)
    {
        $device = Device::where('room', $request->input('id'))->first(['room']);

        $client = Client::where('room', $device->room)->with("purchases")->first();
        
        return response()->json($client);
        return response()->json([
            "id" => $client->id, 
            "name" => $client->name, 
            "email" => $client->email, 
            "room" => $client->room, 
            "welcome_message" => $client->welcome_message, 
            "welcome_image" => env('APP_API_URL') . "/images/device/welcome/" . urlencode($client->welcome_image), 
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
                $item_purchased = Channel::find($purchase['purchasable_id']);
            } elseif ($purchase['purchasable_type'] == "Movie") {
                $item_purchased = Movie::find($purchase['purchasable_id']);
            }
            $purchase =  new Purchase();
            $purchase->client_id = $client->id;
            $item_purchased->purchase()->save($purchase);
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

    // section with section items
    public function getSections ()
    {
        $sections = Section::with('sectionItem')->where('active', true)->get();
        $sections->transform(function ($section) {
            $section->icon = Storage::disk('public')->url('/hotel/images/' . $section->icon);
            $section->sectionItem->transform(function ($sectionitem){
                $sectionitem->poster = Storage::disk('public')->url('/hotel/images/' . $sectionitem->poster);
                return $sectionitem;
            });
            return $section;
        });  
        return $sections;
    }

    // service 
    public function getServices ()
    {
        return Service::where('active', true)->get();
    }

    public function getWeather ()
    {
        $response  = json_decode('{
            "query": {
                "count": 0,
                "created": "2018-03-14T16:13:40Z",
                "lang": "en-US",
                "results": {
                    "channel": {
                        "units": {
                            "speed": "Km"
                        },
                        "wind": {
                            "speed": "2"
                        },
                        "astronomy": {
                            "sunrise": "5:26",
                            "sunset": "6:30"
                        },
                        "item": {
                            "condition": {
                                "code": "26",
                                "temp": "17",
                                "text": ""
                            },
                            "forecast": [
                                { 
                                    "code": "26",
                                    "high": "20",
                                    "low": "17",
                                    "text": ""
                                },
                                {
                                    "code": "26",
                                    "high": "21",
                                    "low": "17",
                                    "text": ""
                                },
                                {
                                    "code": "31",
                                    "high": "22",
                                    "low": "19",
                                    "text": ""
                                },
                                {
                                    "code": "31",
                                    "high": "22",
                                    "low": "19",
                                    "text": ""
                                },
                                {
                                    "code": "27",
                                    "high": "20",
                                    "low": "17",
                                    "text": ""
                                },
                                {
                                    "code": "31",
                                    "high": "21",
                                    "low": "18",
                                    "text": ""
                                },
                                {
                                    "code": "31",
                                    "high": "22",
                                    "low": "18",
                                    "text": ""
                                }
                            ],
                            "guid": {
                                "isPermaLink": ""
                            }
                        }
                    }
                }
            }
        }', true);
	    return response()->json($response);
    }
}
