<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170822_070424_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey(),
            'email'         => $this->string()->notNull()->unique(),
            'username'      => $this->string()->notNull()->unique(),
            'password'      => $this->string()->notNull(),
            'auth_key'      => $this->string(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer(),
            'lastlogin_at'  => $this->integer(),
        ], $tableOptions);

    }


    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropTable('{{%user}}');

    }

}
