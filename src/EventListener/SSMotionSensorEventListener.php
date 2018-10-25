<?php

namespace Tchoblond59\SSMotionSensor\EventListener;

use App\Sensor;
use App\Events\MSMessageEvent;
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
        \Log::useFiles(storage_path('/logs/ssmotion.log'), 'info');
        \Log::debug('Get MESSAGE');
        $sensor = Sensor::where('node_address', '=', $event->message->getNodeId())
            ->where('sensor_address', '=', $event->message->getChildId())
            ->where('classname', '=', '\Tchoblond59\SSMotionSensor\Models\SSMotionSensor')
            ->first();
        if($sensor && $event->message->getCommand()==1 && $event->message->getType()==16)
        {
            $state = $event->message->getMessage();
            $ss_event = new SSMotionSensorEvent($sensor, $state);
            event($ss_event);
        }
    }
}
