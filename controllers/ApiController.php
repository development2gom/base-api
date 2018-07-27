<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use app\models\searchs\ConCategoiriesSearch;
use app\models\EntProductosSearch;
use app\models\EntLocalidadesSearch;
use app\models\EntLocalidades;

/**
 * ConCategoiriesController implements the CRUD actions for ConCategoiries model.
 */
class ApiController extends Controller
{   
    public $serializer = [
        'class' => 'app\components\SerializerExtends',
        'collectionEnvelope' => 'items',
    ];

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'localidades' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionLocalidades(){
        
        $modelSearch = new EntLocalidadesSearch();
        $dataProvider = $modelSearch->search(Yii::$app->getRequest()->get());

        return $dataProvider;
    }

    public function actionCreate(){
        if(!file_get_contents("php://input")){
            echo "Error";
        }

        $json = json_decode(file_get_contents("php://input") );

        if(!isset($json->nombre)){
            echo "Falta nombre";
        }

        $localidad = new EntLocalidades();
        $localidad->txt_nombre = $json->nombre;
        
        if(!$localidad->save()){
            print_r($localidad->errors);
        }
    }
}