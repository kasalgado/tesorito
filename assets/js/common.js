import $ from 'jquery';
import updateWidgetTemplate from "./updateWidgetTemplate";
import updateDaily from './updateDaily';

export default function commonEvents() {
    $('.action-completed').on('click', function() {
        updateWidget($(this).attr('data-url'), $(this).attr('id'));
    });
    
    $('.set-homework').on('click', function() {
        updateHomework($(this).attr('data-url'));
    });

    $('.fetch-week').on('click', function() {
        updateWidgetTemplate('meal', $(this).attr('data-url'));
    });
}

function updateWidget(url, name) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'html'
    }).done(function(data) {
        $('#widget-' + name).html(data);
        $('.action-completed').on('click', function() {
            updateWidget($(this).attr('data-url'), name);
        });
        updateDaily();
    });
}

function updateHomework(url) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'html'
    }).done(function(data) {
        $('#widget-homework').html(data);
        $('.set-homework').on('click', function() {
            updateHomework($(this).attr('data-url'));
        });
        updateDaily();
    });
}
