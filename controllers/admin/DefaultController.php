<?php

namespace panix\mod\seo\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\mod\seo\models\SeoUrl;
use panix\mod\seo\models\search\SeoUrlSearch;
use panix\mod\seo\models\SeoParams;
use panix\engine\controllers\AdminController;
use yii\helpers\Url;

class DefaultController extends AdminController
{

    public function actions()
    {
        return [
            'delete' => [
                'class' => \panix\engine\actions\DeleteAction::class,
                'modelClass' => SeoUrl::class,
            ],
        ];
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $this->pageName = Yii::t('seo/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'label' => Yii::t('app/default', 'CREATE'),
                'url' => ['/admin/seo/default/create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];

        $this->view->params['breadcrumbs'][] = [
            'label' => $this->module->info['label'],
            'url' => $this->module->info['url'],
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new SeoUrlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = SeoUrl::findModel($id);
        $this->pageName = Yii::t('app/default', 'UPDATE');
        $post = Yii::$app->request->post();
        $isNew = $model->isNewRecord;



        $this->view->params['breadcrumbs'][] = [
            'label' => $this->module->info['label'],
            'url' => $this->module->info['url'],
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;


        $isNew = $model->isNewRecord;
        if ($model->load($post)) {
            /* update url */
            if ($model->validate()) {
                if ($model->save()) {

                    /* save or update MetaName */
                    /*if (isset($_POST['SeoMain'])) {

                        $items = $_POST['SeoMain'];
                        foreach ($items as $name => $item) {

                            if (isset($item['id'])) {
                                $mod = SeoMain::model()->findByPk($item['id']);
                            } else {

                                $mod = new SeoMain();
                                $mod->name = $name;
                                $mod->url = $model->id;
                            }

                            $mod->attributes = $item;
                            $mod->save(false, false);
                        }
                    }

                    $this->saveParams($model);*/

                    return $this->redirectPage($isNew, $post);

                }
            }
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    protected function saveParams($model)
    {
        $dontDelete = array();

        if (!empty($_POST['param'])) {
            foreach ($_POST['param'] as $main_id => $object) {
                // echo '<pre>'.CVarDumper::dumpAsString($object).'</pre>';


                $i = 0;
                foreach ($object as $key => $item) {
                    $ex = explode('|', $item);
                    $variant = SeoParams::find()->where([
                        'url_id' => $main_id,
                        'param' => $item,
                        //'obj' => $key,
                        'modelClass' => $ex[0]
                    ])->one();
                    // If not - create new.
                    if (!$variant)
                        $variant = new SeoParams();

                    $variant->setAttributes([
                        'url_id' => $main_id,
                        'param' => $item,
                        // 'obj' => $key,
                        'modelClass' => $ex[0]
                    ], false);

                    $variant->save(false);
                    array_push($dontDelete, $variant->id);
                    $i++;
                }


                if (!empty($dontDelete)) {


                    SeoParams::deleteAll(
                        ['AND', 'url_id=:id', ['NOT IN', 'id', $dontDelete]], [':id' => $main_id]);
                } else {

                    SeoParams::find()->where(['url_id' => $main_id])->deleteAll();
                }
            }
        }
        //   die;
    }

    /**
     * Получение списка всех моделей в проекте
     */
    public function getModels()
    {
        $file_list = [];
        //путь к директории с проектами
        //$file_list = scandir(Yii::getPathOfAlias('application.modules.news.models'));
        //$file_list = scandir(Yii::getPathOfAlias('mod.*.models'));
        $models = null;

        foreach (Yii::$app->getModules() as $mod => $obj) {

            if (!in_array($mod, ['admin', 'seo', 'user', 'rbac', 'stats'])) {
                if (file_exists(Yii::getAlias("@vendor/panix/mod-{$mod}/models"))) {
                    $file_list[$mod] = scandir(Yii::getAlias("@vendor/panix/mod-{$mod}/models"));
                }
            }
            /*   if (!in_array($mod, ['admin', 'seo', 'user', 'install', 'stats'])) {
                   if (file_exists(Yii::getAlias("@vendor/panix/mod-{$mod}/models"))) {
                       $file_list[$mod] = \yii\helpers\FileHelper::findFiles(Yii::getAlias("@vendor/panix/mod-{$mod}/models"), [
                                   'only' => ['*.php'],
                           'recursive'=>false
                       ]);
                   }
               }*/

            //если найдены файлы
            if (isset($file_list[$mod])) {
                if (count($file_list[$mod])) {
                    foreach ($file_list[$mod] as $file) {

                        if ($file != '.' && $file != '..' && !preg_match('/Translate|Query|Node|Search/', $file)) {// исключаем папки с назварием '.' и '..'
                            // Yii::import("mod.{$mod}.models.{$file}");
                            $ext = explode(".", $file);

                            $model = $ext[0];
                            $className = "\\panix\\mod\\{$mod}\\models\\{$model}";
                            //  $run = new $className;
                            //  if ($run instanceof \panix\engine\db\ActiveRecord) {
                            //проверяем чтобы модели были с расширением php
                            if (isset($ext[1])) {
                                if ($ext[1] == "php") {
                                    $models[] = array(
                                        'model' => $model,
                                        //  'path' => "//panix//mod//{$mod}//models",
                                        'className' => $className
                                    );
                                    //  $models[] = "mod.{$mod}.models";
                                }
                            }
                            //  }
                        }
                    }
                }
            }
        }

        return $models;
    }
    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
    /**
     * Получение списка артибутов всех моделей
     */
    public function getParams()
    {
        //загружаем модели
        $models = $this->getModels();
        $params = [];
        $i = 0;


        if (count($models)) {
            //  print_r($models);
            //  die;
            foreach ($models as $model) {
                $className = $model['className'];
                $mdl = new $className;
                $modelName = $model['model'];


                //$modelNew = new $mdl();
                if ($mdl instanceof \panix\engine\db\ActiveRecord || $mdl instanceof \yii\db\ActiveRecord) {


//if($mdl!='ShopCategoryNode'){
                    // }
                    /* проверяем существует ли в данном классе функция "tableName"
                     * если она существует, то скорее всего эта модель CActiveRecord
                     * таким образом отсеиваем модели, которые были предназначены для валидации форм не работающих с Базой Данных
                     */
                    //if($mdl!='ShopCategoryNode'){
                    //   $modelNew = new $model['className'];
                    //if (method_exists($mdl, "tableName")) {
                    //$tableName = $mdl::tableName();
                    //if (($table = $modelNew->getDb()->getSchema()->getTableNames($tableName)) !== null) {
                    //  $item = new $mdl;

                    foreach ($mdl as $attr => $val) {

                        $params[$i]['group'] = $modelName;
                        $params[$i]['name'] = $attr;
                        $params[$i++]['value'] = $model['className'] . '|' . $attr;
                    }

                    /*
                     * проверяем есть ли связи у данной модели
                     */
                    /* if (method_exists($mdl, "relations")) {
                      if (count($mdl->relations())) {
                      $relation = $mdl->relations();
                      foreach ($relation as $key => $rel) {
                      // выбираем связи один к одному или многие к одному
                      if (($rel[0] == "CHasOneRelation") || ($rel[0] == "CBelongsToRelation")) {

                      if (!in_array($rel[1], array('CategoriesModel'))) {

                      Yii::import("{$model['path']}.{$rel[1]}");
                      // echo $model['path'];
                      $newRel = new $rel[1];
                      foreach ($newRel as $attr => $nR) {
                      $params[$i]['group'] = $mdl;
                      $params[$i]['name'] = $key . "." . $attr;
                      $params[$i++]['value'] = $mdl . "/" . $key . "." . $attr;
                      }
                      }
                      }
                      }
                      }
                      } */
                    //}
                    //  }
                }
            }
            /*
             * если есть модели работающие с базой то возвращаем массив данных
             * иначе возвращаем пустой массив
             */
        }
        return $params;
    }

    /*
     * ajax function
     * add to Form, fields for MetaName
     */

    public function actionAddmetaname()
    {
        $model = new SeoMain;
        $model->name = $_POST['name'];
        $this->renderPartial("_formMetaName", array('model' => $model));
    }

    /*
     * ajax function
     * delete MetaName
     */

    public function actionDeletemetaname()
    {
        SeoMain::model()->findByPk($_POST['id'])->delete();
    }

    /*
     * ajax function
     * add to Form, fields for MetaProperty
     */

    public function actionAddmetaproperty()
    {
        $model = new SeoParams();
        $this->renderPartial("_formMetaParams", array('model' => $model, 'count' => $_POST['count']));
    }

    /*
     * ajax function
     * delete MetaProperty
     */

    public function actionDeleteMetaProperty()
    {
        SeoParams::model()->findByPk($_POST['id'])->delete();
    }

    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('app/default', 'SETTINGS'),
                'url' => array('/admin/seo/settings'),
                'icon' => Html::icon('settings'),
            ],
            [
                'label' => Yii::t('seo/default', 'REDIRECTS'),
                'url' => array('/admin/seo/redirects'),
                'icon' => Html::icon('refresh'),
            ],
        ];
    }

}
