<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\CollegeTeams;
use App\Models\Participant;
use App\Models\UniversityTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class QuestionaryController extends Controller
{
    // рендерим и выводим участника
    public function showQuestionaryParticipant($id)
    {
        $data = DB::table('participants')->select('role_id','contest_id')->find($id);
        $genders = DB::table('genders')->get();
        if($data->contest_id === 1) {
            switch ($data->role_id) {
                case 1:
                    $participant = DB::table('participants')
                        ->select('participants.*','university_teams.*','roles.name as role_name','participants.id as participant_id','participants.status as participant_status')
                        ->leftJoin('university_teams','participants.team_id','=','university_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->where('participants.id',$id)
                        ->first();
                    return view('admin.questionary.university_participant',[
                        'participant'=>$participant,
                        'genders'=>$genders,
                    ]);
                case 2:
                    $participant = DB::table('participants')
                        ->select('participants.*','roles.name as role_name', 'university_teams.count_participants','university_teams.name','participants.id as participant_id','participants.status as participant_status')
                        ->leftJoin('university_teams','participants.team_id','=','university_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->where('participants.id',$id)
                        ->first();
                    return view('admin.questionary.university_participant',[
                        'participant'=>$participant,
                        'genders'=>$genders,
                    ]);
            }
        }else if($data->contest_id === 2) {
            switch ($data->role_id) {
                case 1:
                    $participant = DB::table('participants')
                        ->select('participants.*','college_teams.*','roles.name as role_name','participants.id as participant_id','participants.status as participant_status')
                        ->leftJoin('college_teams','participants.team_id','=','college_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->where('participants.id',$id)
                        ->first();
                    return view('admin.questionary.college_participant',[
                        'participant'=>$participant,
                        'genders'=>$genders,
                    ]);
                case 2:
                    $participant = DB::table('participants')
                        ->select('participants.*','roles.name as role_name', 'college_teams.count_participants','college_teams.name','participants.id as participant_id','participants.status as participant_status')
                        ->leftJoin('college_teams','participants.team_id','=','college_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->where('participants.id',$id)
                        ->first();
                    return view('admin.questionary.college_participant',[
                        'participant'=>$participant,
                        'genders'=>$genders,
                    ]);
            }
        }else {
            return abort(404);
        }
    }

    // возвращаем каунт участников команды
    private function countParticipantsTeam($team_id, $contest_id) : string
    {
        $count = Participant::where(['team_id' => $team_id,'contest_id'=>$contest_id,'status'=>1])->count();

        return $count;
    }

    // обновляем статус или данные участника
    public function changeStatusOrUpdateData(Request $request)
    {

        $data = $request->request->all();

        if(isset($data['change']) && $data['change'] === 'status') {
            $count = $this->countParticipantsTeam($data['team_id'], $data['contest']);
//            dd($count,$data['count_participants']);
            if($count === $data['count_participants']) return redirect()->back()->with('unsuccessfully','В данной команде уже достаточное количество учащихся');
            MailController::sendMessageParticipant($data['email']);
            if($data['count_participants']-$count === 1) MailController::sendMessageAllTeams($data['team_id'], $data['contest']);
            if($data['contest'] === '1') {
                switch ($data['role_id']) {
                    case '1':
                        Participant::where('id', $data['participant_id'])
                            ->update(['status' => 1]);
                        UniversityTeams::where('id',$data['team_id'])
                            ->update(['status'=>1]);
                        return redirect()->route('admin.university')->with('success','Участник успешно подтвержден!');
                    case '2':
                        Participant::where('id', $data['participant_id'])
                            ->update(['status' => 1]);
                        return redirect()->route('admin.university')->with('success','Участник успешно подтвержден!');
                }
            }else if($data['contest'] === '2') {
                switch ($data['role_id']) {
                    case '1':
                        Participant::where('id', $data['participant_id'])
                            ->update(['status' => 1]);
                        CollegeTeams::where('id',$data['team_id'])
                            ->update(['status'=>1]);
                        return redirect()->route('admin.college')->with('success','Участник успешно подтвержден!');
                    case '2':
                        Participant::where('id', $data['participant_id'])
                            ->update(['status' => 1]);
                        return redirect()->route('admin.college')->with('success','Участник успешно подтвержден!');
                }
            }

        }else if(isset($data['change']) && $data['change'] === 'data') {
            if($data['contest']==='1') {
                switch ($data['role_id']) {
                    case '1':
                        Participant::where('id', $data['participant_id'])
                            ->update(['fullname' => $data['fullname'], 'gender_id'=>$data['gender'], 'program'=>$data['training_program'],'curs'=>$data['kurs'],'faculty'=>$data['faculty'],'specialty'=>$data['specialty'], 'age'=>$data['age'],'email'=>$data['email'],'phone'=>$data['phone']]);
                        UniversityTeams::where('id',$data['team_id'])
                            ->update(['name'=>$data['new_name_team'],'direction'=>$data['project_direction'],'topic'=>($data['project_topic']==='Другое'?null:$data['project_topic']),'other_topic'=>$data['name_topic'],'university'=>($data['university']==='Другое'?null:$data['university']),'other_university'=>$data['name_university'],'count_participants'=>$data['count_participants'],'leader_fullname'=>$data['fullname_leader'],'mentor_fullname'=>$data['fullname_mentor']]);
                        return redirect()->back()->with('success','Данные успешно обновлены');
                    case '2':
                        Participant::where('id', $data['participant_id'])
                            ->update(['fullname' => $data['fullname'], 'gender_id'=>$data['gender'], 'program'=>$data['training_program'],'curs'=>$data['kurs'],'faculty'=>$data['faculty'],'specialty'=>$data['specialty'], 'age'=>$data['age'],'email'=>$data['email'],'phone'=>$data['phone']]);
                        return redirect()->back()->with('success','Данные успешно обновлены');
                }
            }else if($data['contest']==='2') {
                switch ($data['role_id']) {
                    case '1':
                        Participant::where('id', $data['participant_id'])
                            ->update(['fullname' => $data['fullname'], 'gender_id'=>$data['gender'],'curs'=>$data['kurs'],'faculty'=>$data['faculty'],'specialty'=>$data['specialty'], 'age'=>$data['age'],'email'=>$data['email'],'phone'=>$data['phone']]);
                        CollegeTeams::where('id',$data['team_id'])
                            ->update(['name'=>$data['new_name_team'],'direction'=>$data['project_direction'],'topic'=>($data['project_topic']==='Другое'?null:$data['project_topic']),'other_topic'=>$data['name_topic'],'college'=>($data['college']==='Другое'?null:$data['college']),'other_college'=>$data['name_college'],'count_participants'=>$data['count_participants'],'leader_fullname'=>$data['fullname_leader_college']]);
                        return redirect()->back()->with('success','Данные успешно обновлены');
                    case '2':
                        Participant::where('id', $data['participant_id'])
                            ->update(['fullname' => $data['fullname'], 'gender_id'=>$data['gender'], 'curs'=>$data['kurs'],'faculty'=>$data['faculty'],'specialty'=>$data['specialty'], 'age'=>$data['age'],'email'=>$data['email'],'phone'=>$data['phone']]);
                        return redirect()->back()->with('success','Данные успешно обновлены');
                }
            }else {
                return abort(401);
            }
        }else {
            return abort(401);
        }


    }
}
