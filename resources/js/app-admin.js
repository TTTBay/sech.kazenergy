require('./bootstrap');
require('./validation');

$(document).ready(function () {
    // выводим инпут
    $('#project_topic').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_project_topic').css('display', 'block');
        }else {
            $('.other_project_topic').css('display', 'none');
        }
    })

    // если установлен value другое то скрываем и наоборот #University#
   if($('#university option:selected').text() === 'Другое') {
       $('.other_university').css('display','block');
   }else {
       $('.other_university').css('display','none');
   }

    // если установлен value другое то скрываем и наоборот #College#
    if($('#college option:selected').text() === 'Другое') {
        $('.other_college').css('display','block');
    }else {
        $('.other_college').css('display','none');
    }

        // show/hide university
    $('#university').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_university').css('display', 'block');
        }else {
            $('.other_university').css('display', 'none');
        }
    })
    // show/hide college
    $('#college').change(function (e) {
        if(e.target.value === 'Другое') {
            $('.other_college').css('display', 'block');
        }else {
            $('.other_college').css('display', 'none');
        }
    })

    // выводим темы для направления при рендере
    let educational = $('#educational').val();
    let direction = $('#project_direction option:selected').text();
    if (educational == 'university') {
        let topics = Lang.get('universities.topic');
        $('#project_topic').children().not('option:disabled').remove();
        jQuery.each(topics, function(i, val) {
            if(direction == i.split('.')[2]) {
                $('#project_topic').append($('<option>', {
                    value: val,
                    text: val,
                    selected: ($('.hidden_topic').val() == val)
                }))
            }
        });
        $('#project_topic').append($('<option>', {
            value: "Другое",
            text: Lang.get('questionary.other'),
            selected: ($('.hidden_topic').val() == '')
        }));
    }else if(educational == 'college') {
        let topics = Lang.get('colleges.topic');
        $('#project_topic').children().not('option:disabled').remove();
        jQuery.each(topics, function (i, val) {
            if (direction == i.split('.')[2]) {
                $('#project_topic').append($('<option>', {
                    value: val,
                    text: val
                }))
                if($('.hidden_topic').val() == val) {
                    $('#project_topic option').attr('selected','selected')
                }
            }
        });
        $('#project_topic').append($('<option>', {
            value: "Другое",
            text: Lang.get('questionary.other')
        }))

    }
// если установлен value другое то скрываем и наоборот #Topic#

    if($('#project_topic option:selected').text() === 'Другое') {
        $('.other_project_topic').css('display','block');
    }else {
        $('.other_project_topic').css('display','none');
    }

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

    // показываем нужную программу
    if($('#bachelor').val()==='Бакалавриат') {
        $('.magistracy').css('display', 'none')
        $('.bachelor').css('display', 'block')
    }else if($('#magistracy').val()==='Магистатура') {
        $('.magistracy').css('display', 'block')
        $('.bachelor').css('display', 'none')
    }

        // меняем программу при change
    $('.training-program').change(function (e) {
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
})
