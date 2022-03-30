@extends('layouts.app')


@section('content')
    @if ($message = Session::get('success'))
        <div class="row justify-content-center">
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <form id="form-update" action="{{route('updateQuestionary',['id'=>$participant->participant_id])}}" method="POST" autocomplete="off">
                @csrf
                @if($participant->role_id===1)
                    <input type="hidden" value="{{$participant->team_id}}" name="team_id">
                @endif
                <input type="hidden" value="{{$participant->role_id}}" name="role_id">
                <input type="hidden" value="{{$participant->contest_id}}" name="contest_id">
                <div class="form-content">
                    <p class="font-weight-bold">Статус участника: <span class="font-weight-light">{{$participant->role_name}}<span></p>
                    <div class="form-group">
                        <label for="fullname">{{__('questionary.fullname.label')}}  <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $participant->fullname }}">
                        <small class="form-text text-muted font-italic">(Доступен для редактирования)</small>
                    </div>

                    <p class="font-weight-bold">Пол: <span class="font-weight-light">{{$participant->gender_name}}</span></p>
                    <p class="font-weight-bold">Имя команды: <span class="font-weight-light">{{$participant->name}}</span></p>
                    @if($participant->role_id===1)
                    <p class="font-weight-bold">Количество человек: <span class="font-weight-light">{{$participant->count_participants}}</span></p>
                    <p class="font-weight-bold">Наименование направления: <span class="font-weight-light">{{$participant->direction}}</span></p>
                    <p class="font-weight-bold">Наименование темы: <span class="font-weight-light">{{$participant->topic}}</span></p>
                    <p class="font-weight-bold">Колледж: <span class="font-weight-light">{{$participant->college}}</span></p>
                    @endif
                    <p class="font-weight-bold">Факультет: <span class="font-weight-light">{{$participant->faculty}}</span></p>
                    <p class="font-weight-bold">Специальность: <span class="font-weight-light">{{$participant->specialty}}</span></p>
                    <p class="font-weight-bold">Курс: <span class="font-weight-light">{{$participant->curs}}</span></p>
                    @if($participant->role_id===1)
                    <div class="form-group">
                        <label for="fullname_leader_college">Ф.И.О руководителя <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="fullname_leader_college" name="fullname_leader_college" value="{{ $participant->leader_fullname }}">
                        <small class="form-text text-muted font-italic">(Доступен для редактирования)</small>
                    </div>
                    @endif
                    <p class="font-weight-bold">Возраст: <span class="font-weight-light">{{$participant->age}}</span></p>
                    <p class="font-weight-bold">Email: <span class="font-weight-light">{{$participant->email}}</span></p>

                    <div class="form-group">
                        <label for="phone">Ваш телефон <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $participant->phone }}" >
                        <small class="form-text text-muted font-italic">(Доступен для редактирования)</small>
                    </div>

                    <button type="submit" class="btn btn-primary">{{__('questionary.update_button')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
