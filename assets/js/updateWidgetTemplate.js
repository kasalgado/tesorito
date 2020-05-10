import $ from 'jquery';
import commonEvents from './common';
import updateDaily from './updateDaily';
import createDailyChart from './createDailyChart';

export default function(name, js_url) {
    $.ajax({
        type: 'POST',
        url: js_url,
        dataType: 'html'
    }).done(function(data) {
        switch(name) {
            case 'chat':
                $('#widget-chat').append(data).scrollTop($('#widget-chat').prop('scrollHeight'));
                $('.box-message').hide();
                $('#chat-message').val('');
                break;
                
            case 'task':
            case 'homework':
            case 'meal':
                $('#widget-' + name).html(data);
                commonEvents();
                break;
                
            default:
                $('#widget-' + name).html(data);
                break;
        }
    });
}

