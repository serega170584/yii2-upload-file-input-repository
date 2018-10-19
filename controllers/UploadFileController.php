<?php

namespace serega170584\file\controllers;
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
