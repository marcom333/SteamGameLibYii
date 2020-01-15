<?php

namespace app\controllers\clases;

use Yii;
use app\models\Game;
use app\models\GameGenre;
use app\models\CategoryGame;
use app\models\Category;
use app\models\Genre;
use app\models\Metacritic;
use app\models\Screenshots;

class SteamAPI{

    public function getOwnedGames($steamUserId){
        $url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".Yii::$app->params["steam_api"]."&include_played_free_games=1&include_appinfo=1&format=json&steamid=" . $steamUserId;
        $ch = curl_init();
        curl_setopt_array ( $ch, 
            [
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            ]  
        );
        $result = curl_exec ( $ch );
        $obj = json_decode($result);

        return $this->save($obj);
    }

    public function save($result){
        $total = 0;
        $fail = 0;
        foreach($result->response->games as $game){
            $g = new Game();
            $g->id = $game->appid;
            $g->name = $game->name;
            $g->img_icon_url = $game->img_icon_url;
            $g->img_logo_url = $game->img_logo_url;
            if($g->save()){
                $total++;
            }
            else{
                $fail++;
            }
        }
        return ["total"=>$total,"fail"=>$fail];
    }

    public function updateGameInfo($model){
        $url = "https://store.steampowered.com/api/appdetails?appids=" . $model->id;
        $ch = curl_init();
        curl_setopt_array ( $ch, 
            [
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
            ]
        );
        $result = curl_exec ( $ch );
        $obj = json_decode($result);

        return $this->update($obj,$model);
    }

    public function update($result, $model){
        $total = 0;
        $fail = 0;
        $data = null;
        if($result === null)
            return $this->noStore($model);
        if(!isset($result->{$model->id}->data))
            return $this->noStore($model);
        $data = $result->{$model->id}->data;
        $model->required_age = $data->required_age;
        $model->controller_support = isset($data->controller_support)?$data->controller_support:null;
        $model->detailed_description = $data->detailed_description;
        $model->about_the_game = $data->about_the_game;
        
        if(isset($data->pc_requirements) && isset($data->pc_requirements->minimum)){
            $model->pc_requirements_minimum = $data->pc_requirements->minimum;
        }
        if(isset($data->pc_requirements) && isset($data->pc_requirements->recommended)){
            $model->pc_requirements_recomended = $data->pc_requirements->recommended;
        }

        $model->developers = isset($data->developers)?$data->developers[0]:null;
        $model->publishers = isset($data->publishers)?$data->publishers[0]:null;

        if(isset($data->price_overview)){
            $model->price_currency = $data->price_overview->currency;
            $model->initial = $data->price_overview->initial;
        }

            
        $model->platforms = "";
        foreach($data->platforms as $key => $value){
            if($value){
                $model->platforms .= $key . " ";
            }
        }

        $model->background = $data->background;

        /* special data */
        $meta= null;
        if(isset($data->metacritic)){
            if(!$meta = Metacritic::findOne(["game_id"=>$model->id]))
            $meta = new Metacritic();
            $meta->game_id = $model->id;
            $meta->score = $data->metacritic->score;
            $meta->url = $data->metacritic->url;
            $meta->save();
        }
        if(isset($data->categories)){
            foreach($data->categories as $value){
                $cate = null;
                if(!$cate = Category::findOne(["name"=>$value->description])){
                    $cate = new Category();
                    $cate->id = $value->id;
                    $cate->name = $value->description;
                    $cate->Save();
                }
                $cg = new CategoryGame();
                $cg->game_id = $model->id;
                $cg->category_id = $cate->id;
                $cg->save();
            }
        }
        if(isset($data->genres)){
            foreach($data->genres as $value){
                $genre = null;
                if(!$genre = Genre::findOne(["name"=>$value->description])){
                    $genre = new Genre();
                    $genre->id = $value->id;
                    $genre->name = $value->description;
                    $genre->Save();
                }
                $gg = new GameGenre();
                $gg->game_id = $model->id;
                $gg->genre_id = $genre->id;
                $gg->save();
            }
        }
        if(isset($data->screenshots)){
            foreach($data->screenshots as $value){
                $genre = null;
                if(!$genre = Screenshots::findOne(["game_id"=>$model->id,"path_thumbnail"=>$value->path_thumbnail])){
                    $genre = new Screenshots();
                    $genre->path_thumbnail = $value->path_thumbnail;
                    $genre->game_id = $model->id;
                    $genre->Save();
                }
            }
        }
        

        if($model->save()){
            $total++;
        }
        else{
            $fail++;
        }

        return ["total"=>$total,"fail"=>$fail];
    }


    public function noStore($model){
        $model->required_age = 0;
        $model->detailed_description = "No store";
        $model->about_the_game = "No store";
        return $model->save();
    }

}



?>