<div class="panel panel-default roller_shutter_widget roller_shutter_{{$sensor->id}}">
    <div class="panel-heading">
        <h3 class="panel-title">{{$widget->name}} <span class="pull-right">{{$sensor->getBatteryLevel()}}% <i class="fa fa-battery"></i></span></h3>
    </div>
    <div class="panel-body text-center" data-sensor-id="{{$sensor->id}}">
        @if($sensor->getState())
            <div style="background-color: #f34546" class="wc-div">
                <h2>Occupé</h2>
            </div>
        @else
            <div style="background-color: #00ff58" class="wc-div">
                <h2>Libre</h2>
            </div>
        @endif
        <hr>
            Occupé pour la dernière fois <span id="last_busy_{{$sensor->id}}">{{$last_busy->created_at->diffForHumans()}}</span>
    </div>
</div>
