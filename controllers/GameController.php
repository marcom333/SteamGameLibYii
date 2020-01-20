<?php

namespace app\controllers;

use Yii;
use app\models\Game;
use app\models\GameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GameSearch();
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
    public function actionView($id)
    {
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
    public function actionCreate()
    {
        $data = (new clases\SteamAPI)->getOwnedGames(76561198074483365);

        return $this->redirect(['index']);
    }

    public function actionDetails()
    {
        $session = Yii::$app->session;
        foreach(Game::find()->all() as $game ){
            if($game->required_age === null){
                $session->set("game",$game->id);
                (new clases\SteamAPI)->updateGameInfo($game);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionLibrary()
    {
        return $this->render('library', [
            "genres"=>\app\models\Genre::find()->all(),
            "categories"=>\app\models\Category::find()->all(),
            "tags"=>[],
        ]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionFolder()
    {
        return $this->renderPartial('_folder', []);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionGenre($id){
        $genre = \app\models\Genre::findOne(["id"=>$id]);
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
        $games->andFilterWhere(['like', 'genre.name', $genre->name]);

        return $this->renderPartial("_genre",["genre"=>$genre,"games"=>$games->all()]);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionCategory()
    {
        return $this->renderPartial('_cat', []);
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionTag()
    {
        return $this->renderPartial('_tag', []);
    }

}
