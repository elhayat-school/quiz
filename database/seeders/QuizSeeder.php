<?php

namespace Database\Seeders;

use App\Services\FullQuizInsertion;
use App\Services\FullQuizSeed;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuizSeeder extends Seeder
{

    public function run(): void
    {
        $insertor = new FullQuizInsertion;

        $quiz_seed = new FullQuizSeed;

        $insertor->insert($quiz_seed->example1());
    }
}
