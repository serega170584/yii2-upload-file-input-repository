<?php

use yii\db\Migration;

/**
 * Handles the creation of table `krivobokov_files`.
 */
class m181014_205903_create_krivobokov_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('krivobokov_files', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'directory' => $this->string(),
            'extension' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('krivobokov_files');
    }
}
