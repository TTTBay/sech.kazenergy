<?php

namespace App\Exports;

use App\Models\Gender;
use App\Models\Participant;
use App\Models\Role;
use App\Models\CollegeTeams;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollegeExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $colleges = CollegeTeams::all();
        $participants = Participant::where('contest_id','=',2)->where('status','=', 1)->get();
        $college_teams = [];
        foreach ($colleges as $college) {
            foreach ($participants as $participant) {
                if($college->id === $participant->team_id) {
                    $college_teams[] = [
                        'ID'=>$participant->id,
                        'ФИО'=>$participant->fullname,
                        'email'=>$participant->email,
                        'Телефон'=>$participant->phone,
                        'Возраст'=>$participant->age,
                        'Название команды'=>$college->name,
                        'Статус участника'=>Role::where('id','=',$participant->role_id)->value('name'),
                        'Пол'=>Gender::where('id','=',$participant->gender_id)->value('name'),
                        'Количество участников'=>$college->count_participants,
                        'Направление проекта'=>$college->direction,
                        'Тема проекта'=>(empty($college->topic)) ? $college->other_topic : $college->topic,
                        'Название Колледжа'=>(empty($college->college)) ? $college->other_college : $college->college,
                        'Отделение'=>$participant->faculty,
                        'Специальность'=>$participant->specialty,
                        'Курс обучения'=>$participant->curs,
                        'Справка подтверждающая обучение'=>url('/storage/uploads/'.$participant->confirmation_file),
                        'Руководитель'=>(empty($college->leader_fullname)) ? 'Не указан':$college->leader_fullname,
                    ];
                }
            }
        }
        return collect($college_teams);
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
            'Название Колледжа',
            'Отделение',
            'Специальность',
            'Курс обучения',
            'Справка подтверждающая обучение',
            'Руководитель',
        ];
    }
}
