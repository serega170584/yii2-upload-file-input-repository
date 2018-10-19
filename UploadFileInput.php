<?php

namespace serega170584\file;
use kartik\file\FileInput;
use yii\base\Event;
use yii\helpers\Url;

/**
 * Upload file input widget
 */
class UploadFileInput extends FileInput
{
    /**
     * This method is invoked right before the widget is executed.
     *
     * The method will trigger the [[EVENT_BEFORE_RUN]] event. The return value of the method
     * will determine whether the widget should continue to run.
     *
     * When overriding this method, make sure you call the parent implementation like the following:
     *
     * ```php
     * public function beforeRun()
     * {
     *     if (!parent::beforeRun()) {
     *         return false;
     *     }
     *
     *     // your custom code here
     *
     *     return true; // or false to not run the widget
     * }
     * ```
     *
     * @return bool whether the widget should continue to be executed.
     * @since 2.0.11
     */
    public function beforeRun()
    {
        $isBeforeRun = parent::beforeRun();
        $this->pluginOptions['showUploadedThumbs'] = false;
        $this->pluginEvents['filebatchselected'] = 'function() {
            $(this).fileinput("upload");
        }';
        $this->pluginEvents['fileuploaded'] = 'function(event, data, previewId, index) {
            $("#' . $this->options['hiddenOptions']['id'] . '").val(data.response["file_id"]);
        }';
        $uploadUrl = Url::toRoute('/a5821f3c408380773281eb7a544c9b2c');
        if (isset($this->pluginOptions['uploadUrl']) && $this->pluginOptions['uploadUrl']) {
            $uploadUrl = $this->pluginOptions['uploadUrl'];
        }
        $this->pluginOptions['uploadUrl'] = $uploadUrl;
        $uploadExtraData = [];
        if (isset($this->pluginOptions['uploadExtraData']) && $this->pluginOptions['uploadExtraData']) {
            $uploadExtraData = $this->pluginOptions['uploadExtraData'];
        }
        $this->pluginOptions['uploadExtraData'] = $uploadExtraData;
        return $isBeforeRun;
    }
}
