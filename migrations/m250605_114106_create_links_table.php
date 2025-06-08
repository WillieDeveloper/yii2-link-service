<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m250605_114106_create_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'full_body' => $this->string(767)->notNull()->unique(),
            'short_body' => $this->string(20)->notNull()->unique(),
            'clicks_count' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-links-short_body', '{{%links}}', 'short_body', true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('idx-links-short_body', '{{%links}}');

        $this->dropTable('{{%links}}');
    }
}
