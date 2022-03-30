<?php


namespace App\Http\Controllers;


use App\Models\Contest;
use App\Models\Participant;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private static $email = [
        'college'=>'sech-junior@kazenergy.com',
        'university'=>'sech2021@kazenergy.com'
    ];

    public static function sendMessageAdmin($contest_id)
    {
        $contest_name = Contest::where('id','=',$contest_id)->value('name');
        Mail::send('emails.new_participant', ['contest'=>$contest_name], function ($message) use ($contest_id) {
            switch ($contest_id) {
                case 1:
                    $message
                        ->to(self::$email['university'])
                        ->subject(config('app.name'));
                    break;
                case 2:
                    $message
                        ->to(self::$email['college'])
                        ->subject(config('app.name'));
                    break;
            }
        });
    }

    public static function sendMessageParticipant($email)
    {
        Mail::send('emails.confirmed_participant', [], function ($message) use ($email) {
            $message
                ->to($email)
                ->subject(config('app.name'));
        });
    }

    public static function sendMessageAllTeams($team_id, $contest_id)
    {

        $emails = Participant::where(['team_id'=>$team_id, 'contest_id'=>$contest_id])->get('email');
        Mail::send('emails.confirmed_team', [], function ($message) use ($emails) {
            foreach ($emails as $email) {
                $message
                    ->to($email->email)
                    ->subject(config('app.name'));
            }
        });
    }
}
