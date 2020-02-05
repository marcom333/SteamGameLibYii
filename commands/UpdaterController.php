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
        $today = new \DateTime("-2 days");
        $games = Game::find()->where(["<","update",$today->format("Y-m-d")])->orWhere(["is","update",null])->limit(50)->orderBy(["id"=>SORT_ASC])->all();
        $api = new SteamApi();
        echo "First: " . $games[0]->id;
        echo " Last: " .  $games[sizeof($games)-1]->id;
        echo " ... ";
        foreach($games as $game){
            $api->updateGameInfo($game);
        }
        echo "Done";
        return ExitCode::OK;
    }
}
