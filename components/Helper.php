<?php

namespace app\components;

use app\models\TestResults;

class Helper
{
    /**
     * Processing csv file
     * Saving if good
     * And collecting errors if bad
     * @param resource $handle
     * @return array[]
     */
    public static function dataProcessor( $handle): array {
        $badRows = [];
        $goodRows = [];
        $firstRowFlag = true;

        while (($data = fgetcsv($handle, 1000, ",")) !== false)
        {
            if($firstRowFlag) {
                $firstRowFlag = false;
                continue;
            }
            $testTaker = $data[1] ?? '';
            $correctAnswer = $data[2] ?? 0;
            $incorrectAnswer = $data[3] ?? 0;
            if($testTaker && $correctAnswer && $incorrectAnswer){
                $testResults = new TestResults();
                $testResults->test_taker = $testTaker;
                $testResults->correct_answers = $correctAnswer;
                $testResults->incorrect_answers = $incorrectAnswer;
                if($testResults->save()) {
                    $goodRows[] = $testTaker;
                } else {
                    if($testResults->getErrors('test_taker')) {
                        $badRows[] = $testTaker;
                    }
                }
            }
        }

        return ['goodRows' => $goodRows, 'badRows' => $badRows];
    }
}