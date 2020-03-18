<?php

namespace app\controllers\clases;

use Yii;
use app\models\Game;
use app\models\Library;
//use app\models\GameGenre;
//use app\models\CategoryGame;
use app\models\Category;
use app\models\Genre;
use app\models\Tag;

use app\models\Metacritic;
use app\models\Screenshots;
use yii\helpers\ArrayHelper;


class SteamAPI{

    public $genres, $tags, $categories;

    function __construct(){
        $this->genres = ArrayHelper::map(Genre::find()->all(),"name","id");
        $this->tags = ArrayHelper::map(Tag::find()->all(),"name","id");
        $this->categories = ArrayHelper::map(Category::find()->all(),"name","id");
    }

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
            $library = new Library();
            $library->game_id = $game->appid;
            $library->user_id = Yii::$app->user->id;
            $library->save();
            if($g->save()){ $total++; }
            else{ $fail++; }
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
            CURLOPT_COOKIE => 'mature_content=' . 1 . '; path=/',
        ]);
        $result = curl_exec ( $ch );
        $obj = json_decode($result);
        return $this->update($obj,$model);
    }

    public function update($result, $model){
        $total = 0;
        $fail = 0;
        $data = null;
        $model->temp_tag = "";
        $model->temp_category = "";
        $model->temp_genre = "";
        $model->update = (new \DateTime())->format("Y-m-d H:i:s");
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
                $cate = $value->description;
                if(!isset($this->genres[$cate])){//!$cate = Category::findOne(["name"=>$value->description])){
                    $nCate = new Category();
                    $nCate->id = $value->id;
                    $nCate->name = $value->description;
                    $nCate->Save();
                    $this->genres[$cate] = $nCate->id;
                }
                /*$cg = new CategoryGame();
                $cg->game_id = $model->id;
                $cg->category_id = $cate->id;
                $cg->save();*/
                $model->temp_category .= ", " . $cate;
            }
            $model->temp_category = substr($model->temp_category, 1, strlen($model->temp_category));
        }
        if(isset($data->genres)){
            foreach($data->genres as $value){
                $genre = $value->description;//null;
                if(!isset($this->genre[$genre]) ){//!$genre = Genre::findOne(["name"=>$value->description])){
                    $nGenre = new Genre();
                    $nGenre->id = $value->id;
                    $nGenre->name = $value->description;
                    $nGenre->Save();
                    $this->genre[$genre] = $nGenre->id;
                }/*
                $gg = new GameGenre();
                $gg->game_id = $model->id;
                $gg->genre_id = $genre->id;
                $gg->save();*/
                $model->temp_genre .= ", " . $genre;
            }
            $model->temp_genre = substr($model->temp_genre, 1, strlen($model->temp_genre));
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
        $tags = $this->getTags($model->id);
        /*var_dump($tags);
        die();*/
        if($tags){
            foreach($tags as $tag){
                //$tagm = \app\models\Tag::findOne(["name"=>$tag]);
                if(!isset($this->tag[$tag])){//!$tagm){
                    $tagm = new Tag();
                    $tagm->name = $tag;
                    $tagm->save();
                    $this->tag[$tag] = $tagm->id;
                }/*
                $tagmix = new \app\models\GameTag();
                $tagmix->tag_id = $tagm->id;
                $tagmix->game_id = $model->id;
                $tagmix->save();*/
                $model->temp_tag .= ", " . $tag;
            }
            $model->temp_tag = substr($model->temp_tag, 1, strlen($model->temp_tag));
        }
        if($model->save()){ $total++; }
        else{ $fail++; }
        return ["total"=>$total,"fail"=>$fail];
    }

    public function getTags($id){
        $url = "https://store.steampowered.com/app/$id/agecheck/";
        $ch = curl_init();
        curl_setopt_array ( $ch, 
        [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2",
                CURLOPT_COOKIE => 'mature_content=1; path=/',
            ]
        );
        $result = curl_exec ( $ch );
        $result = str_replace("class=\"popup_menu_item\" ","", $result);
        $result = str_replace('/?snr=1_agecheck_agecheck__12"',"/?snr=1_5_9__409\" class=\"app_tag\" style=\"display: none;\"", $result );

        $tags = [];
        $arrays = explode("<a href=\"https://store.steampowered.com/tags/en/",$result);
        foreach( $arrays as $row){
            if(strpos($row,"/?snr=1_5_9__409\" class=\"app_tag\" style=\"display: none;\"")){
                $end = strpos($row, "/?snr=1_5_9__409\" class=\"app_tag\" style=\"display: none;\">");
                $data = substr($row, 0, ($end));
                $data = urldecode($data);
                $tags[$data] = $data;
            }
        }
        foreach($tags as $key => $tag){
            if(strlen($tag) > 100){
                unset($tags[$key]);
            }
        }
        return $tags;
    }

    public function noStore($model){
        $model->required_age = 0;
        $model->detailed_description = "No store";
        $model->about_the_game = "No store";
        return $model->save();
    }
    
}
?>