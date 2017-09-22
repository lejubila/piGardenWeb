/**
 * Created by lejubila on 26/08/16.
 */
function checkExitsElement(arr) {
    var i, max_i;
    for (i = 1, max_i = arguments.length; i < max_i; i++) {
        try{
            arr = arr[arguments[i]];
            if (arr === undefined) {
                return false;
            }
        } catch(err) {
            return false;
        }
    }
    return true;
}

function updateElement(id, data, attr){
    attr = attr || '';
    if($(id).length > 0){
        if(attr == ''){
            if($($(id).get(0)).text() != data){
                $($(id).get(0)).text(data);
            }
        } else {
            if($($(id).get(0)).attr(attr) != data){
                $($(id).get(0)).attr(attr, data);
            }
        }
    }
}

function updateZones(status){
    if(!(typeof status['zones'] === undefined)){
        $.each(status['zones'],function(i,zone){
            updateElement('#btn-zone-'+zone.name, zone.actionHref, 'href');
            updateElement('#btn-zone-'+zone.name+' i', 'fa '+zone.actionButtonClass, 'class');
            updateElement('#btn-zone-'+zone.name+' .button-zone-text', zone.actionButtonText);
            updateElement('#btn-zone-image-'+zone.name, zone.imageSrc, 'src');
            updateElement('.link-zone-'+zone.name+' i', (zone.state == 0 ? 'fa fa-toggle-off' : 'fa fa-toggle-on'), 'class');
            if( zone.cronOpenInText !== null){
                $('#text-btn-zone-open-in-cancel-'+zone.name).html(zone.cronOpenInText);
                if( zone.cronOpenInText != ""){
                    $("#box-zone-"+zone.name+" li.open_in_start").addClass('hidden');
                    $("#box-zone-"+zone.name+" li.open_in_set").removeClass('hidden');
                    $('#btn-zone-'+zone.name+'+button.dropdown-toggle span.glyphicon').addClass('text-danger');
                    $('#text-btn-zone-open-in-cancel-'+zone.name).parents('span.dropdown.hidden').removeClass('hidden');
                } else {
                    $("#box-zone-"+zone.name+" li.open_in_start").removeClass('hidden');
                    $("#box-zone-"+zone.name+" li.open_in_set").addClass('hidden');
                    $('#btn-zone-'+zone.name+'+button.dropdown-toggle span.glyphicon').removeClass('text-danger');
                    $('#text-btn-zone-open-in-cancel-'+zone.name).parents('span.dropdown.hidden').addClass('hidden');
                }
            }
            var dropdown = $('#btn-zone-'+zone.name+'+button.dropdown-toggle');
            if(dropdown.length > 0 ){
                if(zone.state == 0){
                    dropdown.prop('disabled', false);
                } else {
                    dropdown.prop('disabled', true);
                }
            }
        });
    }
}

function updateNotify(status){
    if(!(typeof status['messages'] === undefined)){
        $.each(status['messages'],function(type, messages){
            $.each(messages,function(i, message){
                new PNotify({
                    // titSession::all()le: 'Regular Notice',
                    text: message,
                    type: type,
                    icon: false
                });
            });
        });
    }
}

function callBackAjaxError(jqXHR, textStatus, errorThrown){
    console.log(jqXHR);
    console.log(textStatus);
    new PNotify({
        // titSession::all()le: 'Regular Notice',
        text: textStatus,
        type: warning,
        icon: false
    });
}

(function($){
    $(document).ready(function(){
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
})(jQuery);

function htmlDecode(input){
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}