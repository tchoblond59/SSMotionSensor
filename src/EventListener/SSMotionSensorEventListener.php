<?php

namespace Tchoblond59\SSMotionSensor\EventListener;

use App\Sensor;
use App\Events\MSMessageEvent;
use App\SensorFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Tchoblond59\SSMotionSensor\Events\SSMotionSensorEvent;

class SSMotionSensorEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MSMessageEvent  $event
     * @return void
     */
    public function handle(MSMessageEvent $event)
    {
        //\Log::useFiles(storage_path('/logs/ssmotion.log'), 'info');
        $sensor = Sensor::where('node_address', '=', $event->message->getNodeId())
            ->where('sensor_address', '=', $event->message->getChildId())
            ->where('classname', '=', '\Tchoblond59\SSMotionSensor\Models\SSMotionSensor')
            ->first();

        if($sensor && $event->message->getCommand()==1 && $event->message->getType()==16)
        {
            $sensor = SensorFactory::create($sensor->classname, $sensor->id);
            $state = $event->message->getMessage();
            $last_busy_text = $sensor->getLastBusy()->created_at->diffForHumans();
            \Log::debug($sensor);
            $ss_event = new SSMotionSensorEvent($sensor, $state, $last_busy_text);
            event($ss_event);
        }
    }
}
