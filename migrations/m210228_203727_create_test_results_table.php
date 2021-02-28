<?php

use yii\db\Migration;

/**
 * Handles the creation of table `test_results`.
 */
class m210228_203727_create_test_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test_results', [
            'id' => $this->primaryKey(),
            'test_taker' => $this->string(25)->notNull()->unique(),
            'correct_answers' => $this->integer(11)->notNull(),
            'incorrect_answers' => $this->integer(11)->notNull(),
        ]);
    }

    // Just for some reason :)
    /*
     CREATE TABLE `test_results` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `test_taker` varchar(25) COLLATE latin1_bin NOT NULL,
     `correct_answers` int(11) NOT NULL,
     `incorrect_answers` int(11) NOT NULL,
     PRIMARY KEY (`id`),
     UNIQUE KEY `uq_test_taker` (`test_taker`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1062 DEFAULT CHARSET=latin1 COLLATE=latin1_bin
    */

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test_results}}');
    }
}
