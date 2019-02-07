/****************SSMotionSensor JS Plugin****************/
$(function() {
    e.channel('chan-ssmotionsensor')
        .listen('.Tchoblond59\\SSMotionSensor\\Events\\SSMotionSensorEvent', function (e) {
            $('#last_busy_'+e.sensor.id).text(e.last_busy_text);
            if(e.state == 1)
            {
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div').css("background-color", "#f34546");
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div h2').text("Occupé");
            }
            else
            {
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div').css("background-color", "#00ff58");
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div h2').text("Libre");
            }
        })
});