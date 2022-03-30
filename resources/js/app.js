require('./bootstrap');
require('./validation');

$(document).ready(function () {
    //
    let role = localStorage.getItem('role');
    if(role !== null && role !== '') {
        $(`#roles>input#${role}`).prop('checked', true)
        formShowHide(role)
    }else {
        $('div.form-content').css('display','none');
    }

    function formShowHide(role) {
        if(role==='skipper') {
            $('.form-content').fadeIn();
            $('.name_team').hide();
            $('.new_name_team').show();
            $('.project_direction').show();
            $('.project_topic').show();
            $('.university').show();
            $('.college').show();
            $('.leader').show();
            $('.mentor').show();
            $('.count_participants').show();
            $('.output_data').hide();
        }else if (role==='crewman') {
            $('.form-content').fadeIn();
            $('.new_name_team').hide();
            $('.project_direction').hide();
            $('.project_topic').hide();
            $('.university').hide();
            $('.college').hide();
            $('.leader').hide();
            $('.mentor').hide();
            $('.count_participants').hide();
            $('.name_team').show();
            $('.output_data').show();
        }else {
            return false;
        }
    }

    $(document).on('change','#roles',function (e) {
        localStorage.setItem('role', e.target.id);
        formShowHide(e.target.id)
    })
    //
    $('#project_topic').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_project_topic').css('display', 'block');
        }else {
            $('.other_project_topic').css('display', 'none');
        }
    })
    //
    $('#university').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_university').css('display', 'block');
        }else {
            $('.other_university').css('display', 'none');
        }
    })
    //
    $('#college').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_college').css('display', 'block');
        }else {
            $('.other_college').css('display', 'none');
        }
    })
    //

    let program = localStorage.getItem('training-program');
    if(program) $('.'+program).css('display', 'block')
    $('.training-program').change(function (e) {
        localStorage.setItem('training-program', e.target.id);
        if(e.target.id === 'bachelor') {
            $('.magistracy').css('display', 'none')
            $('.bachelor').css('display', 'block')
        }else if(e.target.id === 'magistracy') {
            $('.bachelor').css('display', 'none')
            $('.magistracy').css('display', 'block')
        }else {
            return false;
        }
    })
//
    $('.category').click(function () {
        if(!$('#terms').is(':checked')) {
            $(".terms-alert").css('display', 'block');
            return false;
        }
        return true;
    })

    $(document).on('change', '.name_team',function (e) {
        let id = e.target.value;
        let educational = $('#educational').val();
        let outputBlock = $('.output_data');
        const url = `/questionary/${educational}/`
        $.ajax({
            'url': url+id,
            'type': 'GET',
            success: function (data) {
                switch (educational) {
                    case 'college':
                        return (
                            outputBlock.empty(),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.captain')}: <span class="font-weight-normal font-italic">"${data[0].fullname}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.name')}: <span class="font-weight-normal font-italic">"${data[0].name}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.college')}: <span class="font-weight-normal font-italic">"${data[0].college ?? data[0].other_college}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.direction')}: <span class="font-weight-normal font-italic">"${data[0].direction}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.topic')}: <span class="font-weight-normal font-italic">"${data[0].topic ?? data[0].other_topic}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.leader')}: <span class="font-weight-normal font-italic">"${data[0].leader_fullname ?? '-'}"<span></p>`)
                        )
                    case 'university':
                        return (
                            outputBlock.empty(),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.captain')}: <span class="font-weight-normal font-italic">"${data[0].fullname}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.name')}: <span class="font-weight-normal font-italic">"${data[0].name}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.university')}: <span class="font-weight-normal font-italic">"${data[0].university ?? data[0].other_university}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.direction')}: <span class="font-weight-normal font-italic">"${data[0].direction}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.topic')}: <span class="font-weight-normal font-italic">"${data[0].topic ?? data[0].other_topic}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.leader')}: <span class="font-weight-normal font-italic">"${data[0].leader_fullname ?? '-'}"<span></p>`),
                            outputBlock.append(`<p class="font-weight-bold">${Lang.get('site-content.teams_data.mentor')}: <span class="font-weight-normal font-italic">"${data[0].mentor_fullname ?? '-'}"<span></p>`)
                    )
                    default:
                        return false;
                }

            },
            error: function (data) {
                console.log(data)
            }
        })
    })

    // выводим модалку и проверяем чекбокс, затем отправляем форму на сервер
    $('.form-send').click(function () {
        // $('#politicsModal').modal('hide');
        if(!$('#politics').is(':checked')) {
            $('.error-politic').text(Lang.get('validation.politic')).css({'display': 'inline-block', 'color':'red'});
            return false
        }
        $('#form')[0].submit();
        $('.form-send').prop('disabled',true);
    });

    // динамически выводим темы направления для колледжей и универов
    $('.project_direction').change(function (e) {
        let educational = $('#educational').val();
        let direction = e.target.value;
        if (educational == 'university') {
            let topics = Lang.get('universities.topic');
            $('#project_topic').children().not('option:disabled').remove();
            jQuery.each(topics, function(i, val) {
                if(direction == i.split('.')[2]) {
                    $('#project_topic').append($('<option>', {
                        value: val,
                        text: val
                    }))
                }
            });
            $('#project_topic').append($('<option>', {
                value: "Другое",
                text: Lang.get('questionary.other')
            }))
        }else if(educational == 'college') {
            let topics = Lang.get('colleges.topic');
            $('#project_topic').children().not('option:disabled').remove();
            jQuery.each(topics, function(i, val) {
                if(direction == i.split('.')[2]) {
                    $('#project_topic').append($('<option>', {
                        value: val,
                        text: val
                    }))
                }
            });
            $('#project_topic').append($('<option>', {
                value: "Другое",
                text: Lang.get('questionary.other')
            }))
        }
    })



})

