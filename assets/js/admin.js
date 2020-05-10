import '../css/admin.scss';

import $ from 'jquery';
import updateWidgetTemplate from './updateWidgetTemplate';
import commonEvents from './common';
import createDailyChart from './createDailyChart';

$(document).ready(function() {
    var runInterval = 0;
    
    commonEvents();
    createDailyChart($('#daily-milestones').val());
    
    $('.fetch-data').on('click', function() {
        if ($(this).attr('id') === 'chat') {
            
            if ($(this).attr('aria-expanded') == "false") {
                runInterval = setInterval(fetchChatMessages, 5000);
                $('#chat-messages-container').scrollTop($('#chat-messages-container').prop('scrollHeight'));
            } else {
                clearInterval(runInterval);
            }
            return;
        }

        if ($(this).hasClass('collapsed')) {
            updateWidgetTemplate($(this).attr('id'), $(this).attr('data-url'));
        }
    });
    
    $('#btn-message-send').on('click', function() {
        var message = $('#chat_chat_text').val();
        
        if (message == '') {
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: $(this).attr('data-url'),
            data: {
                message: message
            },
            dataType: 'html'
        }).done(function(data) {
            var div_messages = $('#chat-messages-container');
            div_messages.append(data);
            div_messages.scrollTop(div_messages.prop('scrollHeight'));
            $('#chat_chat_text').val('');
        });
    });

    $('.assign-week').change(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('data-url'),
            data: {
                week: this.value
            },
            dataType: 'json'
        });
    });
    
    function fetchChatMessages()
    {
        $.ajax({
            type: 'POST',
            url: $('#chat').attr('data-url'),
            dataType: 'html'
        }).done(function(data) {
            if (data.length > 0) {
                var div_messages = $('#chat-messages-container');
                div_messages.append(data);
                div_messages.scrollTop(div_messages.prop('scrollHeight'));
            }
        });
    }
});
