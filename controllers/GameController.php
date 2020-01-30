<?php

namespace app\controllers;

use Yii;
use app\models\Game;
use app\models\GameSearch;
use app\models\ZGameSearch;
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
        
        if(Yii::$app->user->identity->rol == 1  && $self){
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
        return $this->render('library', [
            "genres"=>\app\models\Genre::find()->all(),
            "categories"=>\app\models\Category::find()->all(),
            "tags"=>\app\models\Tag::find()->all(),
            "folders"=>\app\models\Folder::find()->where(['is', 'folder_id' , null])->all(),
        ]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionFolder($id){   
        $subFolder = \app\models\Folder::find()->where(["folder_id"=>$id])->all();
        $games = (new \yii\db\Query())->select([
                "game.id",
                "game.name name",
                "game.img_icon_url",
                'GROUP_CONCAT(DISTINCT folder.name) gname',])->
            from('game')->
            join('LEFT JOIN', 'folder_game', 'folder_game.game_id = game.id')->
            join('LEFT JOIN', 'folder', 'folder.id = folder_game.folder_id')->
            groupBy("game.id")->
            andFilterWhere(['like', 'folder.id', $id])->all();
        
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
        $games = (new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                'GROUP_CONCAT(DISTINCT genre.name) gname',
            ])->
        from('game')->
        join('LEFT JOIN', 'game_genre', 'game_genre.game_id = game.id')->
        join('LEFT JOIN', 'genre', 'genre.id = game_genre.genre_id')->
        groupBy("game.id");
        $games->andFilterWhere(['=', 'genre.id', $id]);

        return $this->renderPartial("_games",["games"=>$games->all()]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionCategory($id){
        $games = (new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                'GROUP_CONCAT(DISTINCT category.name) cname',
            ])->
        from('game')->
        join('LEFT JOIN', 'category_game', 'category_game.game_id = game.id')->
        join('LEFT JOIN', 'category', 'category.id = category_game.category_id')->
        groupBy("game.id")->andFilterWhere(['=', 'category.id', $id]);

        return $this->renderPartial("_games",["games"=>$games->all()]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionTag($id){
        $games = (new \yii\db\Query())->select(
            [
                "game.id",
                "game.name name",
                "game.img_icon_url",
                'GROUP_CONCAT(DISTINCT tag.name) tname',
            ])->
        from('game')->
        join('LEFT JOIN', 'game_tag', 'game_tag.game_id = game.id')->
        join('LEFT JOIN', 'tag', 'tag.id = game_tag.tag_id')->
        groupBy("game.id")->andFilterWhere(['=', 'tag.id', $id]);

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
        if(isset($_POST['addfolder']) && isset($_POST['name']) && $_POST['name']){
            $fold = new \app\models\Folder();
            $fold->folder_id = $path;
            $fold->name = $_POST['name'];
            $fold->user_id = Yii::$app->user->id;
            if($fold->save()){}

        }
        if(isset($_POST['savefolder']) && isset($_POST['name']) && $_POST['name']){
            $fold = new \app\models\Folder();
            $fold->folder_id = $path;
            $fold->name = $_POST['name'];
            $fold->user_id = Yii::$app->user->id;
            if($fold->save()){
                $gamefold = new \app\models\FolderGame();
                $gamefold->folder_id = $fold->id;
                $gamefold->game_id = $id;
                if($gamefold->save()){
                    return $this->redirect(['view','id'=>$id]);
                }
            }

        }
        return $this->render("folder",["folders"=>$folder->all(),"id"=>$id]);
    }

    public function actionDeletefolder($id, $folder){ 
        $model = \app\models\Folder::findOne($folder);
        if($model){ $model->delete(); }
        return $this->redirect(['view','id'=>$id]);
    }
}
