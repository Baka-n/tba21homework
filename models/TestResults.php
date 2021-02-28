<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_results".
 *
 * @property int $id
 * @property string $test_taker
 * @property int $correct_answers
 * @property int $incorrect_answers
 */
class TestResults extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_taker', 'correct_answers', 'incorrect_answers'], 'required'],
            [['correct_answers', 'incorrect_answers'], 'integer'],
            [['test_taker'], 'string', 'max' => 25],
            [['test_taker'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_taker' => 'Test Taker',
            'correct_answers' => 'Correct Answers',
            'incorrect_answers' => 'Incorrect Answers',
        ];
    }
}
