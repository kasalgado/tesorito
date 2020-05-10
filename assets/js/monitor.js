import '../css/monitor.scss';

import $ from 'jquery';
import updateWidgetTemplate from './updateWidgetTemplate';
import commonEvents from './common';
import createDailyChart from './createDailyChart';

$(document).ready(function() {
    var delayFactorCheckWidgetUpdate = 1;
    var countIntentsCheckWidgetUpdate = 0;
    var setIntervalCheckWidgetUpdate;
    
    $('#nav-header').delay(10000).slideUp();
    $('.toggle-nav').on('click', function() {
        $('#nav-header').slideToggle();
    });
    
    $('#widget-chat').scrollTop($('#widget-chat').prop('scrollHeight'));
    setIntervalCheckWidgetUpdate = setInterval(checkWidgetUpdate, 5000);
    
    commonEvents();
    createDailyChart($('#daily-milestones').val());
    
    $('.btn-show-field').on('click', function() {
        $('.box-message').toggle();
        $('#chat-message').focus();
    });
    
    $('#chat-message').keypress(function(e) {
        if (e.which === 13) {
            var message = $('#chat-message').val();
            
            if (message == '') {
                $('.box-message').hide();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: $(this).attr('data-url'),
                data: {
                    message: message,
                    source: 'monitor'
                },
                dataType: 'html'
            }).done(function(data) {
                $('#widget-chat').append(data);
                $('#widget-chat').scrollTop($('#widget-chat').prop('scrollHeight'));
                $('.box-message').hide();
                $('#chat-message').val('');
            });
        }
    });

    function checkWidgetUpdate() {
        $.ajax({
            type: 'POST',
            url: js.url_monitor_observer,
            dataType: 'json'
        }).done(function(data) {
            countIntentsCheckWidgetUpdate++;
            
            if (countIntentsCheckWidgetUpdate === 5 && delayFactorCheckWidgetUpdate <= 12) {
                delayFactorCheckWidgetUpdate++;
                countIntentsCheckWidgetUpdate = 0;
                
                clearInterval(setIntervalCheckWidgetUpdate);
                setIntervalCheckWidgetUpdate = setInterval(checkWidgetUpdate, 3000 * delayFactorCheckWidgetUpdate);
            }
            
            if (data.length > 0) {
                $.each(data, function(index, name) {
                    updateWidgetTemplate(name, $('#widget-' + name).attr('data-url'));
                });
                
                clearInterval(setIntervalCheckWidgetUpdate);
                setIntervalCheckWidgetUpdate = setInterval(checkWidgetUpdate, 3000);
                delayFactorCheckWidgetUpdate = 1;
                countIntentsCheckWidgetUpdate = 0;
            }
        });
    }
});