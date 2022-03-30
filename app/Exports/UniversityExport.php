<?php

namespace App\Exports;

use App\Models\Gender;
use App\Models\Participant;
use App\Models\Role;
use App\Models\UniversityTeams;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class UniversityExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $universities = UniversityTeams::all();
        $participants = Participant::where('contest_id','=',1)->where('status','=', 1)->get();
        $university_teams = [];
        foreach ($universities as $university) {
            foreach ($participants as $participant) {
                if($university->id === $participant->team_id) {
                    $university_teams[] = [
                        'ID'=>$participant->id,
                        'ФИО'=>$participant->fullname,
                        'email'=>$participant->email,
                        'Телефон'=>$participant->phone,
                        'Возраст'=>$participant->age,
                        'Название команды'=>$university->name,
                        'Статус участника'=>Role::where('id','=',$participant->role_id)->value('name'),
                        'Пол'=>Gender::where('id','=',$participant->gender_id)->value('name'),
                        'Количество участников'=>$university->count_participants,
                        'Направление проекта'=>$university->direction,
                        'Тема проекта'=>(empty($university->topic)) ? $university->other_topic : $university->topic,
                        'Название ВУЗа'=>(empty($university->university)) ? $university->other_university : $university->university,
                        'Программа обучения'=>$participant->program,
                        'Факультет'=>$participant->faculty,
                        'Специальность'=>$participant->specialty,
                        'Курс обучения'=>$participant->curs,
                        'Справка подтверждающая обучение'=>url('/storage/uploads/'.$participant->confirmation_file),
                        'Научный руководитель'=>(empty($university->leader_fullname)) ? 'Не указан':$university->leader_fullname,
                        'Ментор'=>(empty($university->mentor_fullname))?'Не указан':$university->mentor_fullname
                    ];
                }
            }
        }
        return collect($university_teams);
    }

    public function headings(): array
    {
        return [
            'ID',
            'ФИО',
            'email',
            'Телефон',
            'Возраст',
            'Название команды',
            'Статус участника',
            'Пол',
            'Количество участников',
            'Направление проекта',
            'Тема проекта',
            'Название ВУЗа',
            'Программа обучения',
            'Факультет',
            'Специальность',
            'Курс обучения',
            'Справка подтверждающая обучение',
            'Научный руководитель',
            'Ментор',
        ];
    }
}
