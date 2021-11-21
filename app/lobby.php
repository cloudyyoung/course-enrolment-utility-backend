<?php

namespace App;

use MongoDB\Bson\ObjectId;
use Flight;

use App\Player;
use App\Base;

class Lobby extends Base
{
    private static $lobby_db;
    private $exist;
    public $lobby_id;
    public $book;
    public $stage;
    public $phase;
    private $player;

    public function __construct($object)
    {
        if (self::$lobby_db == null) {
            self::$lobby_db = Flight::get("larp_db")->lobby;
        }

        if (is_array($object)) $object = (object) $object;

        $lobby = null;
        if (isset($object->lobby_id)) {
            $lobby = self::$lobby_db->findOne(["_id" => new ObjectId($object->lobby_id)]);
        }

        if ($lobby == null) {
            $this->exist = false;
        } else {
            $this->exist = true;
            $this->lobby_id = (string) ($lobby->_id);
            $this->book = $lobby->book;
            $this->stage = $lobby->stage;
            $this->phase = $lobby->phase;

            $this->player = [];
            foreach ($lobby->player as $player) {
                $this->player[] = new Player($player);
            }
        }
    }


    // ************************ Router ************************ //
    public static function Lobby($object, $operation)
    {
        $lobby = new Lobby($object);
        if (!$lobby->exist) {
            Flight::ret(404, "Lobby not found");
            return;
        }

        $joined = false; // If current user is joined in the lobby
        foreach ($lobby->player as $player) {
            if ($player->account_id == Account::$account->account_id) {
                $joined = true;
                break;
            }
        }

        switch ($operation) {
            case null:
                if ($joined) {
                    Flight::ret(200, "OK", $lobby->info("in_room"));
                } else {
                    Flight::ret(200, "OK", $lobby->info("preview"));
                }
                break;

            case "join":
                if ($joined) {
                    Flight::ret(403, "Already joined in room");
                } else {
                    $lobby->join();
                    Flight::ret(200, "OK", $lobby->info("in_room"));
                }
                break;

            default:
                Flight::ret(404, "No method");
                break;
        }
    }
    // ************************ Router ************************ //

    public function info($type = "preview")
    {
        if ($type == "preview") {
            $array = $this->__toArray();
            $array->player = count($this->player);
            return $array;
        } else if ($type == "in_room") {
            $array = $this->__toArray();
            $array->player = $this->player;
            return $array;
        }
    }

    public function join()
    {
        $player = new Player(array(
            "account_id" => Account::$account->account_id,
            "character_id" => 1001,
            "clue" => []
        ));

        $this->player[] = $player;

        self::$lobby_db->updateOne(
            ["_id" => new ObjectId($this->lobby_id)],
            [
                '$push' => [
                    "player" => $player->dump()
                ]
            ]
        );
    }
}
