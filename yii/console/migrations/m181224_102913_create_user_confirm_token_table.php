<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_confirm_token`.
 */
class m181224_102913_create_user_confirm_token_table extends Migration
{
      public function up()
      {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
      }

      public function down()
      {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
      }
}
