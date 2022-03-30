
$(function () {
    $('#form').validate({
        onkeyup: false,
        rules: {
            fullname: {
                required: true
            },
            name_team: {
                required: true,
            },
            new_name_team: {
                required: true,
                remote: {
                    url: "/questionary/check",
                    type: "post",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'education': $('#educational').val(),
                        new_name_team: function() {
                            return $( "#new_name_team" ).val().trim();
                        }
                    }
                }
            },
            count_participants: {
                required: true,
            },
            project_direction: {
                required: true
            },
            project_topic: {
                required: true
            },
            name_topic: {
                required: true
            },
            university: {
                required: true
            },
            name_university: {
                required: true
            },
            training_program: {
                required: true
            },
            kurs: {
                required: true
            },
            faculty: {
                required: true
            },
            specialty: {
                required: true
            },
            confirming_file: {
                required: true,
                extension:"pdf|jpeg|jpg|png",
            },
            fullname_leader_college: {
                required: true
            },
            age: {
                required: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "/questionary/check",
                    type: "post",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        email: function() {
                            return $( "#email" ).val().trim();
                        }
                    }
                }
            },
            phone: {
                required: true,
                remote: {
                    url: "/questionary/check",
                    type: "post",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        phone: function() {
                            return $( "#phone" ).val();
                        }
                    }
                }
            },

        },
        messages: {
            fullname: {
                required: Lang.get('validation.required'),
            },
            name_team: {
                required: Lang.get('validation.required'),
            },
            new_name_team: {
                required: Lang.get('validation.required'),
            },
            count_participants: {
                required: Lang.get('validation.required'),
            },
            project_direction: {
                required: Lang.get('validation.required'),
            },
            project_topic: {
                required: Lang.get('validation.required'),
            },
            name_topic: {
                required: Lang.get('validation.required'),
            },
            university: {
                required: Lang.get('validation.required'),
            },
            name_university: {
                required: Lang.get('validation.required'),
            },
            training_program: {
                required: Lang.get('validation.required'),
            },
            kurs: {
                required: Lang.get('validation.required'),
            },
            faculty: {
                required: Lang.get('validation.required'),
            },
            specialty: {
                required: Lang.get('validation.required'),
            },
            confirming_file: {
                required: Lang.get('validation.required'),
                extension:Lang.get('validation.extension'),
            },
            fullname_leader_college: {
                required: Lang.get('validation.required'),
            },
            age: {
                required: Lang.get('validation.required'),
            },
            email: {
                required: Lang.get('validation.required'),
                email: Lang.get('validation.emails.email'),
            },
            phone: {
                required: Lang.get('validation.required'),
            },
        },
        submitHandler: function(){
            let date = new Date();
            let contest = $('input[name="contest"]').val()
            if(contest == 1) {
                $('.modal-body>.text-justify').empty();
                $('.modal-body>.text-justify').prepend(Lang.get('site-content.politics_', {'name' : $('#fullname').val(),'day' : date.getDate().toString().length==1 ? '0'+(date.getDate()) : date.getDate(), 'month':(date.getMonth()+1).toString().length == 1 ? '0'+(date.getMonth()+1) : date.getMonth()+1, 'year':date.getFullYear()}),)
            }else if(contest == 2) {
                $('.modal-body>.text-justify').empty();
                $('.modal-body>.text-justify').prepend(Lang.get('site-content.politics_junior', {'name' : $('#fullname').val(),'day' : date.getDate().toString().length==1 ? '0'+(date.getDate()) : date.getDate(), 'month':(date.getMonth()+1).toString().length == 1 ? '0'+(date.getMonth()+1) : date.getMonth()+1, 'year':date.getFullYear()}),)
            }
            $('#politicsModal').modal('show');
        }

    });

    $('#form-update').validate({
        rules: {
            fullname: {
                required: true
            },
            fullname_leader_college: {
                required: true,
            },
            phone: {
                required: true,
            },
        },
        messages: {
            fullname: {
                required: Lang.get('validation.required'),
            },
            fullname_leader_college: {
                required: Lang.get('validation.required'),
            },
            phone: {
                required: Lang.get('validation.required'),
            },
        }
    })

    $('#form-participant').validate({
        rules: {
            fullname: {
                required: true
            },
            new_name_team: {
                required: true,
            },
            count_participants: {
                required: true,
            },
            project_direction: {
                required: true
            },
            project_topic: {
                required: true
            },
            name_topic: {
                required: true
            },
            university: {
                required: true
            },
            name_university: {
                required: true
            },
            training_program: {
                required: true
            },
            kurs: {
                required: true
            },
            faculty: {
                required: true
            },
            specialty: {
                required: true
            },
            fullname_leader_college: {
                required: true
            },
            age: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
            },

        },
        messages: {
            fullname: {
                required: 'Данное поле обязательно для заполнения',
            },
            new_name_team: {
                required: 'Данное поле обязательно для заполнения',
            },
            count_participants: {
                required: 'Данное поле обязательно для заполнения',
            },
            project_direction: {
                required: 'Данное поле обязательно для заполнения',
            },
            project_topic: {
                required: 'Данное поле обязательно для заполнения',
            },
            name_topic: {
                required: 'Данное поле обязательно для заполнения',
            },
            university: {
                required: 'Данное поле обязательно для заполнения',
            },
            name_university: {
                required: 'Данное поле обязательно для заполнения',
            },
            training_program: {
                required: 'Данное поле обязательно для заполнения',
            },
            kurs: {
                required: 'Данное поле обязательно для заполнения',
            },
            faculty: {
                required: 'Данное поле обязательно для заполнения',
            },
            specialty: {
                required: 'Данное поле обязательно для заполнения',
            },
            fullname_leader_college: {
                required: 'Данное поле обязательно для заполнения',
            },
            age: {
                required: 'Данное поле обязательно для заполнения',
            },
            email: {
                required: 'Данное поле обязательно для заполнения',
                email: 'Некорректный Email',
            },
            phone: {
                required: 'Данное поле обязательно для заполнения',
            },
        },
    })
})
