@extends('layouts.app')
@include('partials.modal-junior')
@section('content')

    <div class="row">
        <div class="col-sm">
            {{ __('questionary.questionary') }} <span class="text-danger">(* {{__('questionary.required_fields')}})</span>
            <h5>{{$contest->name}}</h5>
        </div>
        <div class="col-sm">

            <form id="form" action="{{route('addQuestionary')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" value="{{$contest->id}}" name="contest">
                <div class="form-group">
                    <label>{{__('questionary.role.label')}}</label>
                    @foreach($roles as $role)
                        <div class="form-check" id="roles">
                            <input class="form-check-input" type="radio" name="role" id="{{$role->role}}" value="{{$role->id}}">
                            <label class="form-check-label" for="{{$role->role}}">
                                {{__('questionary.role.'.$role->role)}}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-content">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="fullname">{{__('questionary.fullname.label')}} <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}">
                            <small id="fullnameHelp" class="form-text text-muted font-italic">{{__('questionary.fullname.help')}}</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('questionary.gender.label')}}</label>
                        @foreach($genders as $gender)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="{{$gender->gender}}" value="{{$gender->id}}" {{ old('gender') == $gender->name ? 'checked' : ''}}>
                                <label class="form-check-label" for="{{$gender->gender}}">
                                    {{__('questionary.gender.'.$gender->gender)}}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group new_name_team">
                        <label for="name_team">{{__('questionary.team.label')}} <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="new_name_team" name="new_name_team" value="{{ old('name_team') }}">
                    </div>

                    <div class="form-group name_team">
                        <label for="name_team">{{__('questionary.team.label')}}<span class="text-danger"> *</span></label>
                        <select class="form-control" id="name_team" name="name_team">
                            <option disabled selected>{{__('questionary.team.placeholder')}}</option>
                            @foreach($college_teams as $college_team)
                                <option value="{{$college_team->id}}">{{$college_team->name}}</option>
                            @endforeach
                        </select>
                        <small id="teamHelp" class="form-text text-muted font-italic">{{__('questionary.team.help')}}</small>
                    </div>

                    <input type="hidden" id="educational" value="college">
                    <div class="output_data">

                    </div>

                    <div class="form-group count_participants">
                        <label>{{__('questionary.count_participants.label')}}<span class="text-danger"> *</span></label>
                        @for ($i = 3; $i < 5; $i++)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="count_participants" id="{{$i}}" value="{{$i}}" {{ old('count_participants') == $i ? 'checked' : ''}}>
                                <label class="form-check-label" for="{{$i}}">
                                    {{$i}}
                                </label>
                            </div>
                        @endfor
                        <label for="count_participants" class="error"></label>
                    </div>

                    <div class="form-group project_direction">
                        <label for="project_direction">{{__('questionary.project_direction.label')}}<span class="text-danger"> *</span></label>
                        <select class="form-control" id="project_direction" name="project_direction">
                            <option disabled selected>{{__('questionary.project_direction.placeholder')}}</option>
                            @foreach(__('colleges.topic') as $key => $direction)
                                <option {{ old('project_direction') == $key ? "selected" : "" }} value="{{$key}}">{{$key}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group project_topic">
                        <label for="project_topic">{{__('questionary.project_topic.label')}}<span class="text-danger"> *</span></label>
                        <select class="form-control" id="project_topic" name="project_topic">
                            <option disabled selected>{{__('questionary.project_topic.placeholder')}}</option>

                        </select>
                        <div class="other_project_topic mt-2">
                            <input type="text" class="form-control" id="other_topic" name="name_topic">
                            <small id="otherHelp" class="form-text text-muted font-italic">{{__('questionary.help')}}</small>
                        </div>
                    </div>

                    <div class="form-group college">
                        <label for="college">{{__('questionary.college.label')}}<span class="text-danger"> *</span></label>
                        <select class="form-control" id="college" name="college">
                            <option disabled selected>{{__('questionary.college.placeholder')}}</option>
                            @foreach(__('colleges.colleges') as $key => $colleges)
                                <optgroup label="{{$key}}">
                                    @foreach($colleges as $college)
                                        <option value="{{$key . ' ' . $college}}">{{$college}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                            <option value="Другое">{{__('questionary.other')}}</option>
                        </select>
                        <div class="other_college mt-2">
                            <input type="text" class="form-control" id="other_college" name="name_college">
                            <small id="otherHelp" class="form-text text-muted font-italic">{{__('questionary.help')}}</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('questionary.specialty_faculty.label_college')}} <span class="text-danger"> *</span></label>
                        <div>
                            <label class="form-check-label" for="faculty">{{__('questionary.specialty_faculty.label_input_college')}}</label>
                            <input id="faculty" name="faculty" type="text" class="form_input" value="{{old('faculty')}}">
                        </div>
                        <div>
                            <label class="form-check-label" for="specialty">{{__('questionary.specialty_faculty.input_specialty')}}</label>
                            <input id="specialty" name="specialty" type="text" class="form_input" value="{{old('specialty')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('questionary.course_of_study')}}<span class="text-danger"> *</span></label>
                        @for ($i = 1; $i < 5; $i++)
                            <div class="form-check">
                                <input {{ old('kurs') == $i ? "checked" : "" }} class="form-check-input" type="radio" name="kurs" id="{{$i.'_'}}" value="{{$i}}">
                                <label class="form-check-label" for="{{$i.'_'}}">
                                    {{$i.' курс'}}
                                </label>
                            </div>
                        @endfor
                        <label for="kurs" class="error"></label>
                    </div>

                    <div class="form-group">
                        <label>{{__('questionary.confirming_file.label_college')}}<span class="text-danger"> *</span></label>
                        <input type="file" class="form-control-file" name="confirming_file">
                        <small id="fileHelp" class="form-text text-muted font-italic">{{__('questionary.confirming_file.help')}}</small>
                    </div>

                    <div class="form-group leader">
                        <label for="fullname_leader_college">{{__('questionary.leader.label_college')}} <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="fullname_leader_college" name="fullname_leader_college" value="{{ old('fullname_leader') }}">
                    </div>

                    <div class="form-group age">
                        <label for="age">{{__('questionary.age.label')}}<span class="text-danger"> *</span></label>
                        <select class="form-control" id="age" name="age">
                            <option disabled selected>{{__('questionary.age.placeholder')}}</option>
                                @for($i=16; $i<22; $i++)
                                    <option {{ old('age') == $i ? "selected" : "" }} value="{{$i}}">{{$i}}</option>
                                @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">{{__('questionary.email')}}<span class="text-danger"> *</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">{{__('questionary.phone_number')}}<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" >
                    </div>

                    <button type="submit" class="btn btn-primary">{{__('questionary.send_button')}}</button>

                </div>

            </form>
        </div>
    </div>
@endsection
