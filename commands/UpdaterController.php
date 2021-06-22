<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

use app\models\Game;
use app\controllers\clases\SteamApi;
/**
 * Update the games in database
 */
class UpdaterController extends Controller
{
    /**
     * Update 50 games in library
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionRun()
    {
        $today = new \DateTime("-5 days");
        $games = Game::find()->
                    where(["<","update",$today->format("Y-m-d")])->
                    orWhere(["is","update",null])->
                    //Where(["temp_tag"=>""])->
                    //limit(150)->
                    orderBy(["id"=>SORT_ASC])->
                    all();
        $api = new SteamApi();
        echo "First: " . $games[0]->id;
        echo " Last: " .  $games[sizeof($games)-1]->id;
        echo " ...\n";
        $all = sizeof($games);
        $where = 0;
        foreach($games as $game){
            $where ++;
            $api->updateGameInfo($game);
            echo "Updating $where/$all [" . $game->name . "]\n";
            sleep(5);
        }
        echo "Done\n";

        $status = Game::find()->select(["dayofmonth(`update`) as day","count(*) as total"])->groupBy(["dayofmonth(`update`)"])->all();

        foreach($status as $row){
            echo "[Day = ". ($row->day?$row->day:"Null") .", Total = $row->total], ";
        }

        return ExitCode::OK;
    }
}
