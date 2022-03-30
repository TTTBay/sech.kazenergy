@extends('admin.layouts.app')

@section('content')
    <div class="row justify-content-between align-items-center">
        <h1>Участники ВУЗов</h1>
        <a href="{{route('file.export',['id'=>1])}}" class="btn btn-light"><img class="excel" src="{{asset('excel.png')}}" alt="icon_excel">Скачать в Excel</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ФИО</th>
            <th scope="col">Статус</th>
            <th scope="col">Команда</th>
        </tr>
        </thead>
        <tbody>
        @foreach($participants as $participant)
        <tr>
            <td>{{$participant->fullname}}</td>
            <td>@if($participant->status === 0) Ждет одобрения @endif</td>
            <td>{{$participant->name}}</td>
            <td><a href="{{route('admin.university.participant',['id'=>$participant->id])}}" class="btn btn-info">Просмотреть</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
