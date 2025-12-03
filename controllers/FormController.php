<?php

namespace app\controllers;

use Yii;
use app\models\Form;
use app\models\FormField;
use app\models\ّFormSubmissions;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\DynamicModel;
use app\models\FormSubmission;

class FormController extends Controller
{
    /**
     * Enforce Auth & Admin Check
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['show', 'list'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'submissions', 'submission-view'],
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
     * List all forms
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Form::find(),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show Form Details + List of its Fields
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $fieldDataProvider = new ActiveDataProvider([
            'query' => FormField::find()->where(['form_id' => $model->id])->orderBy(['ord' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('view', [
            'model' => $model,
            'fieldDataProvider' => $fieldDataProvider,
        ]);
    }

    /**
     * Create a new Form
     */
    public function actionCreate()
    {
        $model = new Form();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update Form
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Delete Form
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Find Model helper
     */
    protected function findModel($id)
    {
        if (($model = Form::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('فرم مورد نظر یافت نشد.');
    }

    /**
     * The Public "Show Form" Action
     */
    public function actionShow($slug)
    {
        $formModel = Form::findOne(['slug' => $slug]);
        if (!$formModel) {
            throw new NotFoundHttpException('فرم مورد نظر یافت نشد.');
        }
        $fields = $formModel->fields; 

        $attributes = [];
        $labels = [];
        foreach ($fields as $field) {
            $attr = 'field_' . $field->id;
            $attributes[] = $attr;
            $labels[$attr] = $field->label;
        }

        $model = new DynamicModel($attributes);
        $model->setAttributeLabels($labels);

        foreach ($fields as $field) {
            $attr = 'field_' . $field->id;
            if ($field->required) $model->addRule($attr, 'required', ['message' => $field->label . ' الزامی است.']);
            if ($field->type == 'number') $model->addRule($attr, 'integer', ['message' => $field->label . ' باید عدد باشد.']);
            if (!empty($field->regex)) $model->addRule($attr, 'match', ['pattern' => $field->regex]);
            $model->addRule($attr, 'safe');
        }

        // 3. Process Submission
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $submission = new FormSubmission();
            $submission->form_id = $formModel->id;

            if ($submission->saveAnswers($model, $fields)) {
                return $this->render('submitted', [
                    'formModel' => $formModel
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'خطایی در ذخیره اطلاعات رخ داد.');
            }
        }

        return $this->render('show', [
            'formModel' => $formModel,
            'model' => $model,
            'fields' => $fields,
        ]);
    }

    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Form::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * List all submissions for a specific Form
     */
    public function actionSubmissions($id)
    {
        $formModel = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => FormSubmission::find()
                ->where(['form_id' => $id])
                ->orderBy(['created_at' => SORT_DESC]),
        ]);

        return $this->render('submissions', [
            'formModel' => $formModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View a specific Submission (The Answers)
     */
    public function actionSubmissionView($id)
    {
        $submission = FormSubmission::findOne($id);
        if (!$submission) {
            throw new NotFoundHttpException('ورودی مورد نظر یافت نشد.');
        }

        return $this->render('submission-view', [
            'submission' => $submission,
        ]);
    }
}