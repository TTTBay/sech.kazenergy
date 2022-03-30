<?php


namespace App\Http\Controllers;
use App\Models\CollegeTeams;
use App\Models\Participant;
use App\Models\UniversityTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QuestionaryController extends Controller
{

    // рендерим форму для выбранного конкурса с нужными данными
    public function showQuestionary()
    {

        if (request()->headers->get('referer') === null) return redirect()->route('home');

        $contest = DB::table('contests')->find(last(request()->segments()));
        $roles = DB::table('roles')->get();
        $genders = DB::table('genders')->get();
        $university_teams = DB::table('university_teams')->get();
        $college_teams = DB::table('college_teams')->get();

        switch ($contest->id){
            case 1:
                return view('questionary.create_university',
                    [
                        'contest'=>$contest,
                        'roles'=>$roles,
                        'genders'=>$genders,
                        'university_teams'=>$this->getSortedTeams($contest),
                    ]
                );
            case 2:
                return view('questionary.create_college',
                    [
                        'contest'=>$contest,
                        'roles'=>$roles,
                        'genders'=>$genders,
                        'college_teams'=>$this->getSortedTeams($contest),
                    ]
                );
            default:
                return abort(404);
        }

    }

    // получаем отсортированные команды (по статусу (не одобрено) и количеству участников)
    private function getSortedTeams($contest)
    {
        $teams = [];
        switch ($contest->id) {
            case 1:
                $counts = DB::table ("participants")
                    ->select(DB::raw("COUNT(1) as count_participant_in_team, team_id"))
                    ->whereRaw(DB::raw('contest_id='.$contest->id))
                    ->groupBy(DB::raw("(team_id)"))
                    ->get();
                $university_teams = UniversityTeams::all(['id','count_participants','name']);
                foreach ($university_teams as $university_team) {
                    foreach ($counts as $count) {
                        if($university_team->id === $count->team_id && $university_team->count_participants>$count->count_participant_in_team) {
                            $teams[] = $university_team;
                        }
                    }
                }
                return $teams;
            case 2:
                $counts = DB::table ("participants")
                    ->select(DB::raw("COUNT(1) as count_participant_in_team, team_id"))
                    ->whereRaw(DB::raw('contest_id='.$contest->id))
                    ->groupBy(DB::raw("(team_id)"))
                    ->get();
                $college_teams = CollegeTeams::all(['id','count_participants','name']);
                foreach ($college_teams as $college_team) {
                    foreach ($counts as $count) {
                        if($college_team->id === $count->team_id && $college_team->count_participants>$count->count_participant_in_team) {
                            $teams[] = $college_team;
                        }
                    }
                }
                return $teams;
            default:
                return [];
        }
    }

    // создаем команду для универов
    private function addTeamUniversity($data) : int
    {
        if($data['role'] === '1') {
            $team = [
                'name'=>$data['new_name_team'],
                'direction'=>$data['project_direction'],
                'topic'=>($data['project_topic'] === 'Другое')?null:$data['project_topic'],
                'other_topic'=>$data['name_topic'],
                'count_participants'=>intval($data['count_participants']),
                'leader_fullname'=>$data['fullname_leader'],
                'mentor_fullname'=>$data['fullname_mentor'],
                'university'=>($data['university']==='Другое') ? null : $data['university'],
                'other_university'=>$data['name_university'],
                'status'=>0
            ];
            $university_team = UniversityTeams::create($team);
            return $university_team->id;
        }else {
            return $data['name_team'];
        }

    }

    // создаем команду для колледжей
    private function addTeamCollege($data) : int
    {
        if($data['role'] === '1') {
            $team = [
                'name'=>$data['new_name_team'],
                'direction'=>$data['project_direction'],
                'topic'=>($data['project_topic'] === 'Другое')?null:$data['project_topic'],
                'other_topic'=>$data['name_topic'],
                'count_participants'=>intval($data['count_participants']),
                'leader_fullname'=>$data['fullname_leader_college'],
                'college'=>($data['college']==='Другое')?null:$data['college'],
                'other_college'=>$data['name_college'],
                'status'=>0
            ];
            $college_team = CollegeTeams::create($team);
            return $college_team->id;
        }else {
            return $data['name_team'];
        }



    }


    // добавляем анкету     *можно вынести добавление участника*
    public function addQuestionary(Request $request)
    {

        $data = $request->request->all();

        if($data['contest'] == '2') {
            $team_id = $this->addTeamCollege($data);
        }else if($data['contest'] == '1') {
            $team_id=$this->addTeamUniversity($data);
        }else {
            return abort(401);
        }

        $fileName = time().'.'.$request->file('confirming_file')->getClientOriginalName();
        $request->file('confirming_file')->move(storage_path() . '/app/public/uploads', $fileName);

        $participant = [
            'fullname'=>$data['fullname'],
            'gender_id'=>isset($data['gender']) ? intval($data['gender']) : null,
            'role_id'=>intval($data['role']),
            'team_id'=>$team_id,
            'contest_id'=>intval($data['contest']),
            'program'=>isset($data['training_program']) ? $data['training_program'] : null,
            'curs'=>intval($data['kurs']),
            'faculty'=>$data['faculty'],
            'specialty'=>$data['specialty'],
            'confirmation_file'=>$fileName,
            'hash_link'=>base64_encode(time()),
            'age'=>$data['age'],
            'email'=>$data['email'],
            'phone'	=>$data['phone'],
            'status'=>0
        ];

        $result = Participant::create($participant);
        $email = $result->email;
        $link = route('showUpdateQuestionary', ['hash'=>$result->hash_link]);

        try {
            Mail::send('emails.processing', ['url'=>$link], function ($message) use ($email) {
                $message
                    ->to($email)
                    ->subject(config('app.name'));
            });
            MailController::sendMessageAdmin($result->contest_id);
        } finally {
            return redirect()->route('home')->with('message','Заявка создана успешно!');
        }
    }

    // получаем данные по команде универа
    public function getDataUniversity($team_id)
    {
        $university_teams = DB::table('university_teams')
            ->Leftjoin('participants', 'university_teams.id', '=', 'participants.team_id')
            ->select('university_teams.*', 'participants.fullname')
            ->where('participants.role_id','=','1')->where('participants.contest_id','=','1')
            ->where('university_teams.id','=',$team_id)->get();

        return response()->json($university_teams);
    }

    // получаем данные по команде колледжа
    public function getDataCollege($team_id)
    {
        $college_teams = DB::table('college_teams')
            ->Leftjoin('participants', 'college_teams.id', '=', 'participants.team_id')
            ->select('college_teams.*', 'participants.fullname')
            ->where('participants.role_id','=','1')->where('participants.contest_id','=','2')
            ->where('college_teams.id','=',$team_id)->get();

        return response()->json($college_teams);
    }

    // проверка на существования email and number tel and team name
    public function checkData(Request $request)
    {
        if($request->email) {
            $email = Participant::where('email','=',$request->email)->exists();
            if($email) {
                return response()->json(__('validation.emails.remote'));
            }else {
                return response()->json(true);
            }
        }else if($request->phone) {
            $phone = Participant::where('phone','=',$request->phone)->exists();
            if($phone) {
                return response()->json(__('validation.phone.remote'));
            }else {
                return response()->json(true);
            }
        }else if($request->new_name_team && $request->education === 'college') {
            $name_team = CollegeTeams::where('name','=',$request->new_name_team)->exists();
            if($name_team) {
                return response()->json(__('validation.teams.remote'));
            }else {
                return response()->json(true);
            }
        }else if($request->new_name_team && $request->education === 'university') {
            $name_team = UniversityTeams::where('name','=',$request->new_name_team)->exists();
            if($name_team) {
                return response()->json(__('validation.teams.remote'));
            }else {
                return response()->json(true);
            }
        }
    }

    // проверка на существование хэша
    private function checkHash($hash) : bool
    {
        $exists = Participant::where('hash_link','=',$hash)->exists();
        return $exists;
    }

    // получаем данные учасника для вывода
    private function getDataParticipant($contest_id, $role_id, $hash)
    {
        if($contest_id===2) {
            switch ($role_id) {
                case 1:
                    $participant = DB::table('participants')
                        ->select('participants.*', 'college_teams.*','college_teams.status as team_status', 'roles.name as role_name', 'genders.name as gender_name','participants.id as participant_id')
                        ->leftJoin('college_teams','participants.team_id','=','college_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->leftJoin('genders','participants.gender_id','=','genders.id')
                        ->where('hash_link','=',$hash)
                        ->first();
                    return $participant;
                case 2:
                    $participant = DB::table('participants')
                        ->select('participants.*','roles.name as role_name', 'genders.name as gender_name', 'college_teams.name','participants.id as participant_id')
                        ->leftJoin('college_teams','participants.team_id','=','college_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->leftJoin('genders','participants.gender_id','=','genders.id')
                        ->where('hash_link','=',$hash)
                        ->first();
                    return $participant;
            }
        }else if($contest_id===1) {
            switch ($role_id) {
                case 1:
                    $participant = DB::table('participants')
                        ->select('participants.*', 'university_teams.*','university_teams.status as team_status', 'roles.name as role_name', 'genders.name as gender_name','participants.id as participant_id')
                        ->leftJoin('university_teams','participants.team_id','=','university_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->leftJoin('genders','participants.gender_id','=','genders.id')
                        ->where('hash_link','=',$hash)
                        ->first();
                    return $participant;
                case 2:
                    $participant = DB::table('participants')
                        ->select('participants.*','roles.name as role_name', 'genders.name as gender_name', 'university_teams.name','participants.id as participant_id')
                        ->leftJoin('university_teams','participants.team_id','=','university_teams.id')
                        ->leftJoin('roles','participants.role_id','=','roles.id')
                        ->leftJoin('genders','participants.gender_id','=','genders.id')
                        ->where('hash_link','=',$hash)
                        ->first();
                    return $participant;
            }
        }
    }

    // рендерим форму для обновление анкет
    public function showUpdateQuestionary($hash)
    {
        $result = $this->checkHash($hash);
        if($result) {
            $data = DB::table('participants')
                ->select('role_id','contest_id', 'status')
                ->where('hash_link','=',$hash)
                ->first();
            if($data->status === 0) {
                $participant = $this->getDataParticipant($data->contest_id, $data->role_id, $hash);
                if($participant->contest_id === 2) {
                    return view('questionary.update_college',['participant'=>$participant]);
                }else if($participant->contest_id === 1) {
                    return view('questionary.update_university',['participant'=>$participant]);
                }
            }else {
                abort(404);
            }
        }else {
            abort(404);
        }
    }

    // обновляем записи учасников
    public function updateQuestionary(Request $request, $id)
    {
        $data = $request->request->all();
        if($data['contest_id']==='2') {
            switch ($data['role_id']) {
                case '2':
                    Participant::where('id', $id)
                        ->update(['fullname' => $data['fullname'], 'phone'=>$data['phone']]);
                    return redirect()->back()->with('success','Данные успешно обновлены');
                case '1':
                    Participant::where('id', $id)
                        ->update(['fullname' => $data['fullname'], 'phone'=>$data['phone']]);
                    CollegeTeams::where('id',$data['team_id'])
                        ->update(['leader_fullname'=>$data['fullname_leader_college']]);
                    return redirect()->back()->with('success','Данные успешно обновлены');
            }
        }else if($data['contest_id']==='1') {
            switch ($data['role_id']) {
                case '2':
                    Participant::where('id', $id)
                        ->update(['fullname' => $data['fullname'], 'phone'=>$data['phone']]);
                    return redirect()->back()->with('success','Данные успешно обновлены');
                case '1':
                    Participant::where('id', $id)
                        ->update(['fullname' => $data['fullname'], 'phone'=>$data['phone']]);
                    UniversityTeams::where('id',$data['team_id'])
                        ->update(['leader_fullname'=>$data['fullname_leader'],'mentor_fullname'=>$data['fullname_mentor']]);
                    return redirect()->back()->with('success','Данные успешно обновлены');

            }
        }
    }

}
