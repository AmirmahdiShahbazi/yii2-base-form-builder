<?php

namespace app\controllers;

use Yii;
use app\models\FormField;
use app\models\Form;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class FormFieldController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Create a field for a specific Form ID
     */
    public function actionCreate($form_id)
    {
        // Verify form exists
        $form = Form::findOne($form_id);
        if (!$form) {
            throw new NotFoundHttpException('Form not found.');
        }

        $model = new FormField();
        $model->form_id = $form_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                // Redirect back to the Form View
                return $this->redirect(['form/view', 'id' => $form_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * Update a Field
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['form/view', 'id' => $model->form_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Delete a Field
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $formId = $model->form_id;
        $model->delete();

        return $this->redirect(['form/view', 'id' => $formId]);
    }

    protected function findModel($id)
    {
        if (($model = FormField::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('فیلد مورد نظر یافت نشد.');
    }
}