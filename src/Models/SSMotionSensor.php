<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 25/10/18
 * Time: 14:21
 */

namespace Tchoblond59\SSMotionSensor\Models;
use App\Message;
use App\Mqtt\MSMessage;
use App\Sensor;

class SSMotionSensor extends Sensor
{
    public function getWidget(\App\Widget $widget)
    {
        return view('ssmotion::widget')->with(['widget' => $widget,
            'sensor' => $this,
            'last_busy' => $this->getLastBusy(),
        ]);
    }

    public function getLastBusy()
    {
        $last_busy = Message::where('node_address', $this->node_address)
            ->where('sensor_address', $this->sensor_address)
            ->where('type', 16)
            ->where('value', 1)
            ->orderBy('created_at', 'desc')
            ->first();
        return $last_busy;
    }

    public function getState()
    {
        $last_message = Message::where('node_address', $this->node_address)
            ->where('sensor_address', $this->sensor_address)
            ->where('type', 16)
            ->orderBy('created_at', 'desc')
            ->first();

        if($last_message)
        {
            return $last_message->value;
        }
        else
        {
            return -1;
        }
    }

    public function getJs()
    {
        return ['js/tchoblond59/ssmotionsensor/ssmotionsensor.js'];
    }
}