import $ from 'jquery';
require('bootstrap');

$(document).ready(function() {
    $('#meal_week').change(function() {
        fetchWeek($(this).attr('data-url'), this.value);
    });
    
    function fetchWeek(url, week) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                week: week
            },
            dataType: 'html'
        }).done(function(data) {
            $('#days-container').html(data);
            $('#btn-submit-plan').attr('disabled', false);
        });
    }
});