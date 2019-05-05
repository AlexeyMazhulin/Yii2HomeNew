<?php

use yii\db\Migration;
use app\components\AuthComponent;

/**
 * Class m190503_130608_UpdateFirstUsers
 */
class m190503_130608_UpdateFirstUsers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('users',
                        ['password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
                         'auth_key' => \Yii::$app->security->generateRandomString()],
                        ['id' => 1] );

        $this->update('users',
            ['password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
                'auth_key' => \Yii::$app->security->generateRandomString()],
            ['id' => 2] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('users',
            ['password_hash' => '',
                'auth_key' => '' ],
            ['id' => 1] );

        $this->update('users',
            ['password_hash' => '',
                'auth_key' => '' ],
            ['id' => 2] );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190503_130608_UpdateFirstUsers cannot be reverted.\n";

        return false;
    }
    */
}
