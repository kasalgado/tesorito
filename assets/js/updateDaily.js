import $ from 'jquery';
import createDailyChart from './createDailyChart';

export default function updateDaily() {
    $.ajax({
        type: 'POST',
        url: $('#daily-milestones').attr('data-url'),
        dataType: 'html'
    }).done(function(data) {
        $('#widget-daily').html(data);
        createDailyChart($('#daily-milestones').val());
    });
}