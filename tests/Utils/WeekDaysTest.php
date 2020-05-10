<?php declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Utils\WeekDays;

class WeekDaysTest extends TestCase
{
    public function testCanGetDays()
    {
        $translatorMock = $this->createMock(TranslatorInterface::class);
        $translatorMock->method('trans')->with($this->isType('string'));
        
        $days = new WeekDays($translatorMock);
        $weekDays = $days->get();
        
        $this->assertCount(7, $weekDays);
    }
}
