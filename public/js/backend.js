/**
 * Created by david on 08/04/17.
 */
$(document).ready(function(){
    updateDashboard('/jsonDashboardStatus');
});
function updateDashboard(urlAction)
{
    $.ajax({
        type : "GET",
        url : urlAction,
        dataType: 'json',
        beforeSend: function(jqXHR) {
        },
        success: function (data, textStatus, jqXHR) {
            //console.log(data);
            updateDashboardExec(data);
            updateZones(data);
            updateNotify(data);
        },
        error: function( jqXHR, textStatus, errorThrown ){
            callBackAjaxError(jqXHR, textStatus, errorThrown);
        },
        complete: function(jqXHR, textStatus){
        }
    });

    setTimeout(function() {
        updateDashboard(urlAction);
    }, 20000);
}
function updateDashboardExec(data){
    //console.log(typeof data);

    if (checkExitsElement(data, 'last_rain_sensor')){
        updateElement('#last_rain_sensor', data['last_rain_sensor']);
    }
    if (checkExitsElement(data, 'last_rain_online')){
        updateElement('#last_rain_online', data['last_rain_online']);
    }
    if (checkExitsElement(data, 'weather', 'observation_time')){
        updateElement('#observation_time', data['weather']['observation_time']);
    }
    if (checkExitsElement(data, 'weather', 'icon_url')){
        updateElement('#icon_url', data['weather']['icon_url'], 'src');
    }
    if (checkExitsElement(data, 'weather', 'weather')){
        updateElement('#weather', data['weather']['weather']);
    }
    if (checkExitsElement(data, 'weather', 'temp_c')){
        updateElement('#temp_c', data['weather']['temp_c']);
    }
    if (checkExitsElement(data, 'weather', 'feelslike_c')){
        updateElement('#feelslike_c', data['weather']['feelslike_c']);
    }
    if (checkExitsElement(data, 'weather', 'wind_degress_style')){
        updateElement('#windCompass', data['weather']['wind_degress_style'], 'style');
    }
    if (checkExitsElement(data, 'weather', 'wind_kph')){
        updateElement('#wind_kph', data['weather']['wind_kph']);
    }
    if (checkExitsElement(data, 'weather', 'wind_dir')){
        updateElement('#wind_dir', data['weather']['wind_dir']);
    }
    if (checkExitsElement(data, 'weather', 'wind_gust_kph')){
        updateElement('#wind_gust_kph', data['weather']['wind_gust_kph']);
    }
    if (checkExitsElement(data, 'weather', 'pressure_mb')){
        updateElement('#pressure_mb', data['weather']['pressure_mb']);
    }
    if (checkExitsElement(data, 'weather', 'relative_humidity')){
        updateElement('#relative_humidity', data['weather']['relative_humidity']);
    }
    if (checkExitsElement(data, 'weather', 'dewpoint_c')){
        updateElement('#dewpoint_c', data['weather']['dewpoint_c']);
    }

}
