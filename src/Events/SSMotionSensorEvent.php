<?php

namespace Tchoblond59\SSMotionSensor\Events;

use App\Sensor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Tchoblond59\LaraLight\Models\LaraLight;
use Tchoblond59\LaraLight\Models\LaraLightConfig;

class SSMotionSensorEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $state=0;
    public $sensor;
    public $last_busy_text;

    public function __construct(Sensor $sensor, $state, $last_busy_text)
    {
        $this->sensor = $sensor;
        $this->state = $state;
        $this->last_busy_text = $last_busy_text;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chan-ssmotionsensor');
    }
}
