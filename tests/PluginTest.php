<?php

namespace PluginTests;

use App\Events\MSMessageEvent;
use App\Mqtt\MSMessage;
use Illuminate\Support\Facades\Event;
use Tchoblond59\SSMotionSensor\EventListener\SSMotionSensorEventListener;
use Tchoblond59\SSMotionSensor\Events\SSMotionSensorEvent;
use Tchoblond59\SSMotionSensor\Models\SSMotionSensor;

class PluginTest extends TestCase
{
    public function testAnonymousStatisticsAreProtected(): void
    {
        $this->get('/widget/ssmotion/infos/1')->assertRedirect('/login');
    }

    public function testWidgetWithoutHistoryShowsUnknownState(): void
    {
        $sensor = $this->sensor(SSMotionSensor::class);
        $widget = $this->widget($sensor);
        $motion = SSMotionSensor::findOrFail($sensor->id);
        $this->assertSame(-1, $motion->getState());
        $this->assertSame(-1, $motion->getBatteryLevel());
        $this->assertNull($motion->getLastBusy());
        $html = $motion->getWidget($widget)->render();
        $this->assertStringContainsString('Etat inconnu', $html);
        $this->assertStringContainsString('Aucune détection', $html);
    }

    public function testPresentationDoesNotCountAsMovementAndBatteryIsReadAtNodeLevel(): void
    {
        $sensor = $this->sensor(SSMotionSensor::class);
        $this->message(16, '1', 0);
        $this->message(16, '1', 1, 2);
        $this->message(0, '85', 3, 255);
        $motion = SSMotionSensor::findOrFail($sensor->id);
        $this->assertSame(-1, $motion->getState());
        $this->assertNull($motion->getLastBusy());
        $this->assertSame('85', $motion->getBatteryLevel());
    }

    public function testFreeStateEventWorksBeforeFirstDetection(): void
    {
        Event::fake([SSMotionSensorEvent::class]);
        $sensor = $this->sensor(SSMotionSensor::class);
        $message = new MSMessage(0);
        $message->set(42, 1, 'V_TRIPPED');
        $message->setMessage('0');
        (new SSMotionSensorEventListener())->handle(new MSMessageEvent($message));
        Event::assertDispatched(SSMotionSensorEvent::class, function ($event) use ($sensor) {
            return $event->sensor->id === $sensor->id && $event->last_busy_text === 'Aucune détection';
        });
    }

    public function testDailyStatisticsPageLoadsAndMissingWidgetReturns404(): void
    {
        $sensor = $this->sensor(SSMotionSensor::class);
        $widget = $this->widget($sensor);
        $this->message(16, '1');
        $this->get('/widget/ssmotion/infos/'.$widget->id)->assertStatus(200)->assertSee('1 personnes');
        $this->get('/widget/ssmotion/infos/999')->assertStatus(404);
    }
}
