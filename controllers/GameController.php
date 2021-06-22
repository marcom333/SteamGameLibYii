<?php

namespace app\controllers;

use Yii;
use app\models\Game;
use app\models\GameSearch;
use app\models\Tag;
use app\models\Genre;
use app\models\Category;
use app\models\Library;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller{
    /**
     * {@inheritdoc}
     */
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','search','library'],
                'rules' => [
                    [
                        'actions' => ['view','library','search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deletefolder'=>['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionSearch($admin = false){
        $searchModel = new GameSearch();
        
        if(Yii::$app->user->identity->rol == 1  && $admin){
            $searchModel->setAdmin();
        }
        $searchModel->setUser_id(Yii::$app->user->id);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        $session->set("background",$model->background);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', ['model' => $model,]);
        }
        return $this->render('view', ['model' => $model,]);
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        ini_set('memory_limit', '1024M');
        $data = (new clases\SteamAPI)->getOwnedGames(Yii::$app->user->id);

        return $this->redirect(['search']);
    }

    public function actionDetails(){
        $session = Yii::$app->session;
        foreach(Game::find()->all() as $game ){
            if($game->required_age === null){
                $session->set("game",$game->id);
                (new clases\SteamAPI)->updateGameInfo($game);
            }
        }

        return $this->redirect(['search']);
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);

        (new clases\SteamAPI)->updateGameInfo($model);

        return $this->redirect(['view', 'id' => $model->id,]);
    }

    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $this->findModel($id)->delete();

        return $this->redirect(['search']);
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionLibrary(){
        $userId = Yii::$app->user->id;

        $genres = Genre::find()->all();
        /*
        $genres = (new \yii\db\Query())->
            select(["genre.name","genre.id"])->
            from("genre")->
            //join('LEFT JOIN', 'game_genre', 'game_genre.genre_id = genre.id')->
            join('LEFT JOIN', 'game', 'game.temp_genre LIKE CONCAT("%", genre.name, "%")')->
            join('LEFT JOIN', 'library', 'library.game_id = game.id')->//game_genre.game_id')->
            where(["user_id"=>$userId])->
            groupBy(["genre.name"])->
            orderBy(["genre.name"=>SORT_ASC])->all();*/
        $tags = Tag::Find()->all();/*
        $tags = (new \yii\db\Query())->
            select(["tag.name","tag.id"])->
            from("tag")->
            //join('LEFT JOIN', 'game_tag', 'game_tag.tag_id = tag.id')->
            join('LEFT JOIN', 'game', 'game.temp_tag LIKE CONCAT("%", tag.name, "%")')->
            join('LEFT JOIN', 'library', 'library.game_id = game.id')->//game_tag.game_id')->
            where(["user_id"=>$userId])->
            groupBy(["tag.name"])->orderBy(["tag.name"=>SORT_ASC])->all();
*/
        $categories = Category::find()->all();
            /*
        $categories = (new \yii\db\Query())->
            select(["category.name","category.id"])->
            from("category")->
            //join('LEFT JOIN', 'category_game', 'category_game.category_id = category.id')->
            join('LEFT JOIN', 'game', 'game.temp_category LIKE CONCAT("%", category.name, "%")')->
            join('LEFT JOIN', 'library', 'library.game_id = game.id')->// category_game.game_id')->
            where(["user_id"=>$userId])->
            groupBy(["category.name"])->orderBy(["category.name"=>SORT_ASC])->all();*/
            
        return $this->render('library', [
            "genres"=>$genres,//\app\models\Genre::find()->all(),
            "categories"=>$categories,
            "tags"=>$tags,
            "folders"=>\app\models\Folder::find()->where(['is', 'folder_id' , null])->andWhere(["user_id"=>Yii::$app->user->id])->all(),
        ]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionFolder($id){   
        $subFolder = \app\models\Folder::find()->where(["folder_id"=>$id])->andWhere(["user_id"=>Yii::$app->user->id])->all();
        
        $games = (new \yii\db\Query())->select([
                "game.id",
                "game.name name",
                "game.img_icon_url",
                'GROUP_CONCAT(DISTINCT folder.name) gname',])->
            from('game')->
            join('LEFT JOIN', 'folder_game', 'folder_game.game_id = game.id')->
            join('LEFT JOIN', 'folder', 'folder.id = folder_game.folder_id')->
            groupBy("game.id")->
            andFilterWhere(['like', 'folder.id', $id])->
            join('LEFT JOIN', 'library', 'library.game_id = game.id')->
            andFilterWhere(['=', 'library.user_id', Yii::$app->user->id])->orderBy(["name"=>SORT_ASC])->all();
        
        $level = $this->getFolderLevel($id,1);
        
        return $this->renderPartial('_folder', ["subFolder"=>$subFolder, "games"=>$games, "level"=>$level]);
    }

    public function getFolderLevel($id,$level){
        $folder = \app\models\Folder::findOne([["id"=>$id]]);
        if($folder->folder_id){
            $level = $this->getFolderLevel($folder->folder_id,$level+1);
        }
        return $level;
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionGenre($id){
        $games = /*(new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                //'GROUP_CONCAT(DISTINCT genre.name) gname',
            ])->
        from('game')->
        //join('LEFT JOIN', 'game_genre', 'game_genre.game_id = game.id')->
        join('LEFT JOIN', 'genre', '1 = 1')->
        andFilterWhere(['=', 'genre.id', $id])->
        join('LEFT JOIN', 'library', 'library.game_id = game.id')->
        andFilterWhere(['=', 'library.user_id', Yii::$app->user->id])->

        where('game.temp_genre like CONCAT("%", genre.name, "%")')->
        groupBy("game.id");*/
        Game::find()->select(["name","id","img_icon_url"])->where(["like","temp_genre",$id])->orderBy(["name"=>SORT_ASC]);

        return $this->renderPartial("_games",["games"=>$games->all()]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionCategory($id){
        $games = /*(new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                //'GROUP_CONCAT(DISTINCT category.name) cname',
            ])->
        from('game')->
        //join('LEFT JOIN', 'category_game', 'category_game.game_id = game.id')->
        join('LEFT JOIN', 'category', '1 = 1')->
        andFilterWhere(['=', 'category.id', $id])->
        join('LEFT JOIN', 'library', 'library.game_id = game.id')->
        andFilterWhere(['=', 'library.user_id', Yii::$app->user->id])->
        where('game.temp_category like CONCAT("%", category.name, "%")')->
        groupBy("game.id")->andFilterWhere(['=', 'category.id', $id]);*/
        Game::find()->select(["name","id","img_icon_url"])->where(["like","temp_category",$id])->orderBy(["name"=>SORT_ASC]);

        return $this->renderPartial("_games",["games"=>$games->all()]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionTag($id){
        //$tag = Tag::findOne($id);
        $games /*= (new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                //'GROUP_CONCAT(DISTINCT tag.name) tname',
            ])->
        from('game')->
        //join('LEFT JOIN', 'game_tag', 'game_tag.game_id = game.id')->
        join('LEFT JOIN', 'tag', '1 = 1')->
        andFilterWhere(['=', 'tag.id', $id])->
        join('LEFT JOIN', 'library', 'library.game_id = game.id')->
        andFilterWhere(['=', 'library.user_id', Yii::$app->user->id])->
        where('game.temp_tag like CONCAT("%", tag.name, "%")')->
        groupBy("game.id");*/
        = Game::find()->select(["name","id","img_icon_url"])->where(["like","temp_tag",$id])->orderBy(["name"=>SORT_ASC]);
        //var_dump($games->all());
        //die();

        return $this->renderPartial("_games",["games"=>$games->all()]);
    }

    public function actionAddfolder($id,$path=null){
        $folder = \app\models\Folder::find()->where(["user_id"=>Yii::$app->user->id]);
        if($path){
            $folder->andWhere(["folder_id"=>$path]);
        }
        else{
            $folder->andWhere(["is","folder_id",null]);
        }
        if(isset($_POST['name']) && $_POST['name']){
            $fold = new \app\models\Folder();
            $fold->folder_id = $path;
            $fold->name = $_POST['name'];
            $fold->user_id = Yii::$app->user->id;
            if($fold->save()){
                if(isset($_POST['option']) && $_POST['option']){
                    $gamefold = new \app\models\FolderGame();
                    $gamefold->folder_id = $fold->id;
                    $gamefold->game_id = $id;
                    if($gamefold->save()){
                        return $this->redirect(['view','id'=>$id]);
                    }
                }
            }
        }
        $current = \app\models\Folder::findOne($path);
        if(Yii::$app->request->isAjax) 
            return $this->renderAjax("folder",["folders"=>$folder->all(),"id"=>$id,"current"=>$current]);
        return $this->render("folder",["folders"=>$folder->all(),"id"=>$id,"current"=>$current]);
    }

    public function actionDeletefolder($id, $folder){ 
        $model = \app\models\FolderGame::findOne(["folder_id"=>$folder, "game_id"=>$id]);
        if($model){ $model->delete(); }
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionSelectfolder($id, $folder_id){ 
        $model = \app\models\Folder::findOne($folder_id);
        if($model){ 
            $game = Game::findOne($id);
            if($game){
                $gamefold = new \app\models\FolderGame();
                $gamefold->folder_id = $model->id;
                $gamefold->game_id = $id;
                $gamefold->save();
            }
        }
        if(Yii::$app->request->isAjax){
            return $this->actionView($id);
        }
        return $this->redirect(['view','id'=>$id]);
    }
    
    public function actionUpdater(){
        $today = new \DateTime("-10 days");
        $games = Game::find()->
                    where(["<","update",$today->format("Y-m-d")])->
                    orWhere(["is","update",null])->
                    limit(100)->
                    orderBy(["id"=>SORT_ASC])->
                    all();
        
        $api = new clases\SteamApi();
        echo "First: " . $games[0]->id;
        echo " Last: " .  $games[sizeof($games)-1]->id;
        echo " ... ";
        foreach($games as $game){
            $api->updateGameInfo($game);
        }
        echo "Done\n";

        $status = Game::find()->select(["dayofmonth(`update`) as day","count(*) as total"])->groupBy(["dayofmonth(`update`)"])->all();

        foreach($status as $row){
            echo "[Day = ". ($row->day?$row->day:"Null") .", Total = $row->total], ";
        }
    }

    public function actionRandom(){
        $library = Library::find()->where(["user_id"=> Yii::$app->user->id])->all();
        //var_dump($library);
        $total = sizeof($library);
        $index = rand(0,$total-1);
        //var_dump($index);
        //die();
        $winner = $library[$index];
        //var_dump($winner);
        return $this->render("view",["model"=>$winner->game]);//->game_id]);
    }

}
