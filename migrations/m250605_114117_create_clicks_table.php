<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clicks}}`.
 */
class m250605_114117_create_clicks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clicks}}', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'ip' => $this->string(50)->notNull(),
            'user_agent' => $this->string(512),
            'referrer' => $this->string(512),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey("fk-clicks-link_id", "{{%clicks}}", "link_id", "{{%links}}", "id", 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk-clicks-link_id", "{{%clicks}}");

        $this->dropTable('{{%clicks}}');
    }
}
