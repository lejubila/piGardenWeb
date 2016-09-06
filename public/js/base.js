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