<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizManagerController extends Controller
{
    public function getQuestion()
    {
        $test_timestamp = time() - 50; // Quiz already started
        $response = $this->presetResponseForQuizTimeContext($test_timestamp);

        /* ************************************************* */
        //      SIMULATING GETTING A REAL QUESTION
        /* ************************************************* */
        if ($response['status'] === 'PLAYING') {

            $lorem = '"لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبورأنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أدمينيم فينايم,كيواس نوستأكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواسأيوتي أريري دولار إن ريبريهينديرأيتفوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايتنيولا باراياتيور. أيكسسيبتيور ساينت أوككايكات كيوبايداتات نون بروايدينت ,سيونت انكيولباكيو أوفيسيا ديسيريونتموليت انيم أيدي ايست لابوريوم."
            "سيت يتبيرسبايكياتيس يوندي أومنيس أستي ناتيس أيررور سيت فوليبتاتيم أكيسأنتييومدولاريمكيو لايودانتيوم,توتام ريم أبيرأم,أيكيو أبسا كيواي أب أللوأنفينتوري فيرأتاتيس ايتكياسي أرشيتيكتو بيتاي فيتاي ديكاتا سيونت أكسبليكابو. نيمو أنيم أبسام فوليوباتاتيم كيوايفوليوبتاس سايت أسبيرناتشر أيوتأودايت أيوت فيوجايت, سيد كيواي كونسيكيونتشر ماجنايدولارس أيوس كيواي راتاشن فوليوبتاتيم سيكيواي نيسكايونت. نيكيو بوررو كيوايسكيومايست,كيوايدولوريم ايبسيوم كيوا دولار سايت أميت, كونسيكتيتيور,أديبايسكاي فيلايت, سيدكيواي نون نيومكيوام ايايوس موداي تيمبورا انكايديونت يوت لابوري أيتدولار ماجنامألايكيوام كيوايرات فوليوبتاتيم. يوت اينايم أد مينيما فينيام, كيواس نوستريوم أكسيركايتاشيميلامكوربوريس سيوسكايبيت لابورايوسام, نايساييوت ألايكيوايد أكس أيا كومودايكونسيكيواتشر؟ كيوايس أيوتيم فيل أيوم أيوري ريبريهينديرايت كيواي ان إيا فوليوبتاتيفيلايت ايسسي كيوم نايهايلموليستايا كونسيكيواتيو,فيلايليوم كيواي دولوريم أيوم فيوجايات كيوفوليوبتاس نيولا باراياتيور؟"';

            $response['body'] = [ // APPENDING THE QUESTION
                'question' => [
                    'content' => mb_substr($lorem, rand(30, 50), rand(60, 80)),
                    'choices' => [
                        ['nb' => 1, 'content' => mb_substr($lorem, rand(150, 170), rand(180, 200))],
                        ['nb' => 2, 'content' => mb_substr($lorem, rand(120, 140), rand(150, 170))],
                        ['nb' => 3, 'content' => mb_substr($lorem, rand(200, 220), rand(230, 250))],
                        ['nb' => 4, 'content' => mb_substr($lorem, rand(100, 120), rand(130, 150))],
                    ]
                ],
            ];
        }
        /* ************************************************* */

        return response()->json($response);
    }

    /**
     * ...++++++++++(start_at)---(start_at + duration)----------...
     *
     * @param int $start_at Quiz starting timestamp in seconds
     * @param int $duration Quiz duration in seconds
     */
    private function presetResponseForQuizTimeContext(int $start_at, int $duration = 180): array
    {
        $time_diff = $start_at - time(); // ! Timezone

        if ($time_diff > 0)
            return ['success' => false, 'status' => 'TOO_EARLY']; // * append T0

        elseif ($time_diff >= -$duration && $time_diff <= 0)
            return ['success' => true, 'status' => 'PLAYING']; // * append a question

        elseif ($time_diff < -180)
            return ['success' => false, 'status' => 'TOO_LATE']; // * append ...
    }
}
