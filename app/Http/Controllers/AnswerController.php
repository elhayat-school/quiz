<?php

namespace App\Http\Controllers;

use App\Services\CurrentQuiz;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public int $currentTimestamp;

    private $currentQuiz;

    public function __construct(CurrentQuiz $currentQuiz)
    {
        $this->currentQuiz = $currentQuiz->get();

        $this->currentTimestamp = time();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recordChoice(Request $request)
    {
        $question = $this->currentQuiz->questions->where('id', $request->question_id)->first();

        $answer = auth()->user()->answers()
            ->where('question_id', $question->id)
            ->firstOrfail();

        if ($this->currentTimestamp - strtotime($answer->served_at) <= $question->duration) {
            $answer->choice_number = $request->choice_number;
            $answer->received_at = date('Y-m-d H:i:s',  $this->currentTimestamp);
            $answer->save();
        }

        return to_route('playground');
    }
}
