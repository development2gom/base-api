<?php
namespace app\controllers;

#https://www.yiiframework.com/doc/api/2.0/yii-data-datafilter

use Yii;
use yii\rest\Controller;
use app\models\EntLocalidades;
use app\models\EntLocalidadesSearch;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;
use yii\web\NotFoundHttpException;

class ApiController extends Controller
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    // Filtros
    public function actionIndex()
    {
        
        $filter = new ActiveDataFilter([
            // Aqui colocar el modelo search
            'searchModel' => 'app\models\EntLocalidadesSearch'
        ]);
        
        $filterCondition = null;
        
        // You may load filters from any source. For example,
        // if you prefer JSON in request body,
        // use Yii::$app->request->getBodyParams() below:
        if ($filter->load(\Yii::$app->request->get())) { 
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }
        
        $query = EntLocalidades::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }
        
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

}
