<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Idsign\Vuetify\Facades\Datatable;
use Illuminate\Http\Request;
use OpenTok\MediaMode;
use OpenTok\OpenTok;
use OpenTok\ArchiveMode;

class RoomController extends Controller
{
    /**
     * @param Request $request
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required'
            ]
        ]);

        $opentok = $this->generateOpenTok();

        $sessionOptions = array(
            'archiveMode' => ArchiveMode::ALWAYS,
            'mediaMode' => MediaMode::ROUTED
        );
        $session = $opentok->createSession($sessionOptions);
        $sessionId = $session->getSessionId();

        Room::create([
            'name' => $request->input('name'),
            'session_id' => $sessionId
        ]);
    }

    public function data(Request $request){
        return Datatable::of(Room::query())->make(true);
    }

    /**
     * @param Room $room
     * @return array
     * @throws \Exception
     */
    public function join(Room $room)
    {
        list($apiKey, $apiSecret) = $this->getCredentials();

        $opentok = $this->generateOpenTok();


        return [
            'token' => $opentok->generateToken($room->session_id),
            'session_id' => $room->session_id,
            'api_key' => $apiKey
        ];
    }

    /**
     * @return OpenTok
     * @throws \Exception
     */
    private function generateOpenTok()
    {
        list($apiKey, $apiSecret) = $this->getCredentials();

        return new OpenTok($apiKey, $apiSecret);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getCredentials()
    {
        $apiKey = env('OPENTOK_API_KEY', null);
        $apiSecret = env('OPENTOK_API_SECRET', null);

        if(!$apiKey || !$apiSecret){
            throw new \Exception('Api Key and/or api secret not set');
        }

        return [
            $apiKey,
            $apiSecret
        ];
    }

    /**
     * @param Room $room
     * @throws \Exception
     */
    public function destroy(Room $room)
    {
        $room->delete();
    }

    public function multiDelete(Request $request)
    {
        $this->validate($request, [
            'items' => [
                'json'
            ]
        ]);

        $items = json_decode($request->input('items'), true);
        foreach ($items as $key => $value){
            $room = Room::findOrFail($value['id']);
            $room->delete();
        }
    }
}
