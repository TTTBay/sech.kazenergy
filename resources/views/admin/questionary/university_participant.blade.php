@extends('admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm">
            <h2>Анкета №{{$participant->participant_id}} - {{$participant->fullname}}</h2>
                <div class="col-sm-6">
                <form id="form-participant" action="{{route('admin.change-data')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" id="educational" value="university">
                    <input type="hidden" value="{{$participant->count_participants}}" name="count_participants">


                    <input type="hidden" value="{{$participant->participant_id}}" name="participant_id">
                    <input type="hidden" value="{{$participant->contest_id}}" name="contest">
                    <input type="hidden" value="{{$participant->team_id}}" name="team_id">
                    <input type="hidden" value="{{$participant->role_id}}" name="role_id">

                    <p>Статус учатника: {{$participant->role_name}}</p>
                    @if($participant->role_id === 2)
                        <p>Участник команды: {{$participant->name}}</p>
                    @endif
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="fullname">Фамилия, Имя, Отчество</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" value="{{ $participant->fullname }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label">Пол</label>
                        <div class="col-sm-6">
                            @foreach($genders as $gender)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="{{$gender->gender}}" value="{{$gender->id}}" {{ $participant->gender_id == $gender->id ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$gender->gender}}">
                                        {{$gender->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($participant->role_id === 1)
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="name_team">Название команды</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="new_name_team" name="new_name_team" value="{{ $participant->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label">Количество участников</label>
                        <div class="col-sm-6">
                            @for ($i = 3; $i < 6; $i++)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="count_participants" id="{{$i}}" value="{{$i}}" {{ $participant->count_participants == $i ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$i}}">
                                        {{$i}}
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group row project_direction">
                        <label class="col-sm-6 col-form-label" for="project_direction">Направление проекта</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="project_direction" name="project_direction">
                                @foreach(__('universities.topic') as $key => $topics)
                                    <option {{ $participant->direction == $key ? "selected" : "" }} value="{{$key}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="project_topic">{{__('questionary.project_topic.label')}}</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="project_topic" name="project_topic">

                            </select>
                            <div class="other_project_topic mt-2">
                                <input value="{{$participant->other_topic}}" type="text" class="form-control form-control-sm" id="other_topic" name="name_topic">
                            </div>
                        </div>
                    </div>
                    <input class="hidden_topic" type="hidden" value="{{$participant->topic}}">

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="university">Название ВУЗа</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="university" name="university">
                                @foreach(__('universities.universities') as $university)
                                    <option {{ $participant->university == $university ? "selected" : "" }} value="{{$university}}">{{$university}}</option>
                                @endforeach
                                <option {{ $participant->university == null ? "selected" : "" }} value="Другое">{{__('questionary.other')}}</option>
                            </select>
                            <div class="other_university mt-2">
                                <input value="{{$participant->other_university}}" type="text" class="form-control form-control-sm" id="other_university" name="name_university">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row training-program">
                        <label class="col-sm-6 col-form-label">Программа и курс обучения</label>
                        <div class="col-sm-6">
                            @foreach(__('questionary.training_program.programs') as $key => $program)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="training_program" id="{{$key}}" value="{{$program}}" {{ $participant->program == $program ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$key}}">
                                        {{$program}}
                                    </label>
                                </div>
                            @endforeach
                            <div class="сourse_study mt-2">
                                @for($i=1; $i<5; $i++)
                                    <div class="form-check bachelor">
                                        <input @if($participant->program === 'Бакалавриат'){{ $participant->curs == $i ? "checked" : "" }}@endif class="form-check-input" type="radio" name="kurs" id="{{$i.'__'}}" value="{{$i}}">
                                        <label class="form-check-label" for="{{$i.'__'}}"> {{$i . ' курс'}} </label>
                                    </div>
                                @endfor
                                @for($i=1; $i<3; $i++)
                                    <div class="form-check magistracy">
                                        <input @if($participant->program === 'Магистратура'){{ $participant->curs == $i ? "checked" : "" }}@endif class="form-check-input" type="radio" name="kurs" id="{{$i.'_'}}" value="{{$i}}">
                                        <label class="form-check-label" for="{{$i.'_'}}">{{$i . ' курс'}}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label">Факультет/Специальность</label>
                        <div class="col-sm-6">
                                <label class="form-check-label" for="faculty">{{__('questionary.specialty_faculty.label_input_university')}}</label>
                                <input id="faculty" name="faculty" type="text" class="form_input" value="{{$participant->faculty}}">
                                <label class="form-check-label" for="specialty">{{__('questionary.specialty_faculty.input_specialty')}}</label>
                                <input id="specialty" name="specialty" type="text" class="form_input" value="{{$participant->specialty}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label">Справка об обучении</label>
                        <div class="col-sm-6">
                            <a target="_blank" href="{{URL::to('/storage/uploads/'.$participant->confirmation_file)}}"><img class="mr-1" width="30px" src="{{asset('img_icon.png')}}" alt="img_icon">Просмотреть</a>
                        </div>
                    </div>

                    @if($participant->role_id === 1)
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="fullname_leader">Научный руководитель</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="fullname_leader" name="fullname_leader" value="{{ $participant->leader_fullname }}">
                        </div>
                    </div>
                    @endif

                    @if($participant->role_id === 1)
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="fullname_mentor">Ментор</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="fullname_mentor" name="fullname_mentor" value="{{ $participant->mentor_fullname }}">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="age">Возраст</label>
                        <div class="col-sm-6">
                        <select class="form-control form-control-sm" id="age" name="age">
                            @for($i=18; $i<26; $i++)
                                <option {{ $participant->age == $i ? "selected" : "" }} value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="email">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ $participant->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="phone">Телефон</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ $participant->phone }}" >
                        </div>
                    </div>

                    {{-- вынести--}}
                    <button name="change" value="status" type="submit" class="btn btn-success mr-4" @if($participant->participant_status===1) disabled @endif>Одобрить</button>

                    <button name="change" value="data" type="submit" class="btn btn-primary">Сохранить изменения</button>
                </form>
            </div>

        </div>
    </div>
@endsection
