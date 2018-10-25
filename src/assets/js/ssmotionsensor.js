/****************SSMotionSensor JS Plugin****************/
$(function() {
    e.channel('chan-ssmotionsensor')
        .listen('.Tchoblond59.SSMotionSensor.Events.SSMotionSensorEvent', function (e) {
            console.log('SSMotionSensorEvent', e);
            if(e.state == 1)
            {
                console.log('STATE 1');
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div').css("background-color", "#f34546");
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div h2').text("Occupé");
            }
            else
            {
                console.log('STATE 0');
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div').css("background-color", "#00ff58");
                $('div[data-sensor-id='+e.sensor.id+'] .wc-div h2').text("Libre");
            }
        })
});