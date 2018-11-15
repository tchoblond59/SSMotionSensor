<?php

namespace Tchoblond59\SSMotionSensor\Controllers;

use App\Http\Controllers\Controller;
use App\Message;
use App\Sensor;
use App\SensorFactory;
use App\Widget;
use Carbon\Carbon;

class SSMotionSensorController extends Controller
{
    public function infos($id)
    {
        $widget = Widget::find($id);
        $sensor = $widget->sensor;
        $sensor = SensorFactory::create($sensor->classname, $sensor->id);
        $date = Carbon::now()->subDay(7);

        $messages = Message::where('node_address', $sensor->node_address)
            ->selectRaw('DATE(created_at) date')
            ->selectRaw('count(*) as compte')
            ->where ('sensor_address', $sensor->sensor_address)
            ->where ('created_at', '>', $date)->orderBy('created_at', 'desc')
            ->where ('command', 1)
            ->where ('value', 1)
            ->where ('type',16)
            ->groupBy('date')
            ->get();

        return view('ssmotion::infos')->with([
            'nbActivation' => $messages ,
            ]);
    }
}
