@extends('layouts.app')

@section('content')

        @if ($message = Session::get('message'))
            <div class="row justify-content-center">
                <div class="alert alert-primary" role="alert">
                    {{$message}}
                </div>
            </div>
        @endif

       <div class="d-flex justify-content-center mb-4">
           <h5>{{__('site-content.questionary')}}</h5>
        </div>

        <div class="row justify-content-center">
            <div class="d-flex justify-content-center mb-4">
                @if(Session::get('locale') == 'kz')
                    <img class="banner" src="{{asset('banner_kz.jpg')}}" alt="banner_kz">
                @else
                    <img class="banner" src="{{asset('banner_ru.jpg')}}" alt="banner_ru">
                @endif
            </div>
            @foreach($contests as $contest)
                <div class="col-sm-4 mb-2">
                    <a href="{{route('showQuestionary', ['id'=>$contest->id])}}" class="d-flex justify-content-center align-items-center category_college category">
                        {{$contest->name}}
                    </a>
                </div>
            @endforeach
            <div class="col-sm-12 mb-3">
                <div class="form-check text-center">
                    <input class="form-check-input" type="checkbox" id="terms">
                    <label class="form-check-label" for="terms">
                        {{__('site-content.terms')}}
                    </label>
                    <p class="terms-alert text-danger">{{__('site-content.terms_text')}}</p>
                </div>
            </div>
            @if(Session::get('locale') == 'kz')
                <div class="col-sm-12 mb-2 text-center  ">
                    <strong>Student Energy Challenge/Student Energy Challenge-Junior байқауларына өтініш қабылдау аяқталды </strong>
                </div>
            @else
                <div class="col-sm-12 mb-2 text-center  ">
                     <strong>Student Energy Challenge/Student Energy Challenge-Junior  завершен </strong>
                </div>
            @endif



            <div class="col-sm-8 text-center">

                <div class="text-justify p-4">
                    {!!__('site-content.politics') !!}
                </div>

            </div>

        </div>

@endsection
