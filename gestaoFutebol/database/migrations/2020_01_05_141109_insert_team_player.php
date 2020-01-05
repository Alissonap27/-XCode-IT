<?php

use App\Match;
use App\Player;
use App\Team;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertTeamPlayer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::transaction(function(){
            $team = new Team();
            $team->id = 1;
            $team->name = "Internacional";
            $team->save();

            $team = new Team();
            $team->id = 2;
            $team->name = "Gremio";
            $team->save();

            $player = new Player();
            $player->id = 1;
            $player->name = "Edenilson";
            $player->position = "Meio";
            $player->number = 8;
            $player->team_id = 1;
            $player->played = 1;
            $player->save();

            $match = new Match();
            $match->id = 1;
            $match->team_id = 1;
            $match->opposing_team_id = 2;
            $match->team_lineup = '[{"id":1,"name":"Edenilson","number":8,"position":"Meio","played":1,"team_id":1}]';
            $match->opposing_team_id = 2;
            $match->match_date = "2020-01-24";
            $match->match_hour = "23:39:00";
            $match->save();
        });
        \DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::transaction(function(){
            $quadrantNordeste = new Quadrant();
            $quadrantNordeste->id = 1003;
            $quadrantNordeste->name = "Nordeste";
            $quadrantNordeste->save();

            $quadrantNoroeste = new Quadrant();
            $quadrantNoroeste->id = 1005;
            $quadrantNoroeste->name = "Noroeste";
            $quadrantNoroeste->save();

            $quadrantSudeste = new Quadrant();
            $quadrantSudeste->id = 1007;
            $quadrantSudeste->name = "Sudeste";
            $quadrantSudeste->save();

            $quadrantSudoeste = new Quadrant();
            $quadrantSudoeste->id = 1009;
            $quadrantSudoeste->name = "Sudoeste";
            $quadrantSudoeste->save();
        });
        \DB::commit();
    }
}
