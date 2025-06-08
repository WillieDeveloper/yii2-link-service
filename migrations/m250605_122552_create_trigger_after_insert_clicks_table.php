<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%trigger_after_insert_clicks}}`.
 */
class m250605_122552_create_trigger_after_insert_clicks_table extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TRIGGER trigger_after_insert_on_clicks_table
            AFTER INSERT
            ON clicks
            FOR EACH ROW
                BEGIN
                    UPDATE links SET clicks_count = clicks_count + 1, updated_at = UNIX_TIMESTAMP(NOW()) WHERE id = NEW.link_id;
                END
        ");
    }

    public function down()
    {
        $this->execute("DROP TRIGGER IF EXISTS trigger_after_insert_on_clicks_table");
    }
}
