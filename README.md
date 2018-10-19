Upload file input repository
============================
This extension attach and upload file to form just clicking browse button: Uploaded file is in db table. We may attach file to any model by file id:   

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist serega170584/yii2-upload-file-input-repository "1.0.0"
```

or add

```
"serega170584/yii2-upload-file-input-repository": "1.0.0"
```

to the require section of your `composer.json` file.

Run migration:
```
yii migrate --migrationPath=@serega170584/file/migrations --interactive=0
```


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \serega170584\file\UploadFileInput::widget(['pluginOptions' => [
                                                             'browseClass' => "btn btn-primary btn-block",
                                                             "showCaption" => false,
                                                             "showRemove" => false,
                                                             "showUpload" => false,
                                                             "maxFileCount" => 1,
                                                             "overwriteInitial" => true,
                                                             'initialPreviewCount' => 1,
                                                             "autoReplace" => true,
                                                             "initialPreview" => [],
                                                             'uploadExtraData' => [
                                                                 'upload_file_key' => Html::getInputName($model, 'image')
                                                             ]
                                                         ],
                                                         'options' => [
                                                             'hiddenOptions' => [
                                                                 'id' => 'hidden_upload'
                                                             ]
                                                         ]
                                                     ]); ?>
                                                     
```
or in form view:
```php
<?= $form->field($model, 'image')->widget(UploadFileInput::class, [
            'pluginOptions' => [
                'browseClass' => "btn btn-primary btn-block",
                "showCaption" => false,
                "showRemove" => false,
                "showUpload" => false,
                "maxFileCount" => 1,
                "overwriteInitial" => true,
                'initialPreviewCount' => 1,
                "autoReplace" => true,
                "initialPreview" => [],
                'uploadExtraData' => [
                    'upload_file_key' => Html::getInputName($model, 'image')
                ]
            ],
            'options' => [
                'hiddenOptions' => [
                    'id' => 'hidden_upload'
                ]
            ]
        ]) ?>
```
After selecting image form send ajax request. Request is showed in uploadUrl pluginOptions. By default uploadUrl = Url::toRoute('/a5821f3c408380773281eb7a544c9b2c')  
Parameters in response: file_id - saved id in image file repository table.
After upload element by id in hiddenOptions get value = file_id. 
For example:
Form view:
```php
<?= $form->field($model, 'image')->widget(UploadFileInput::class, [
            'pluginOptions' => [
                'browseClass' => "btn btn-primary btn-block",
                "showCaption" => false,
                "showRemove" => false,
                "showUpload" => false,
                "maxFileCount" => 1,
                "overwriteInitial" => true,
                'initialPreviewCount' => 1,
                "autoReplace" => true,
                "initialPreview" => [],
                'uploadExtraData' => [
                    'upload_file_key' => Html::getInputName($model, 'image')
                ]
            ],
            'options' => [
                'hiddenOptions' => [
                    'id' => 'hidden_upload'
                ]
            ]
        ]) ?>
```
Controller for ajax response:
```php
<?php

namespace serega170584\file\controllers;
use app\models\Test;
use serega170584\file\models\KrivobokovFiles;
use yii\web\UploadedFile;

/**
 * Class UploadFileController
 * @package serega170584\file\controllers
 */
class UploadFileController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request;
        $uploadFile = UploadedFile::getInstanceByName($request->post('upload_file_key'));
        $directory = $request->post('directory');
        if ($directory === null) {
            $directory = '../upload';
        }
        $fileDirPath = __DIR__ . '/' . $directory;
        if (!file_exists($fileDirPath)) {
            mkdir($fileDirPath);
            chmod($fileDirPath, 0777);
        }
        $tmpFileName = time();
        $filePath = $fileDirPath . '/' . $tmpFileName . '.' . $uploadFile->getExtension();
        $uploadFile->saveAs($filePath);
        $fileModel = new KrivobokovFiles();
        $fileModel->name = basename($uploadFile->name, '.' . $uploadFile->getExtension());
        $fileModel->directory = $fileDirPath;
        $fileModel->extension = $uploadFile->getExtension();
        $fileModel->type = $uploadFile->type;
        $fileModel->size = $uploadFile->size;
        $fileModel->save();
        $resultFilePath = $fileDirPath . '/' . $fileModel->id . '.' . $uploadFile->getExtension();
        rename($filePath, $resultFilePath);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['file_id' => $fileModel->id];
    }
}
```