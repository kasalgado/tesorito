<?php declare(strict_types=1);

namespace App\Service;

class Daily
{
    const NULL_PERCENTAGE = 0;
    const MIDDLE_PERCENTAGE = 50;
    
    private $milestone;
    
    public function calculate(string $homework, array $tasks): void
    {
        $this->calculatePercentage($homework, $tasks);
    }
    
    private function calculatePercentage(string $homework, array $tasks): void
    {
        $completed = 0;
        
        foreach ($tasks as $value) {
            if ($value->getCompleted()) {
                $completed++;
            }
        }

        $this->milestone = ($completed ? round((self::MIDDLE_PERCENTAGE * $completed) / count($tasks)) : 0)
            + ($homework === 'completed' || $homework === 'no' ? self::MIDDLE_PERCENTAGE : self::NULL_PERCENTAGE);
    }
    
    public function get(): float
    {
        return $this->milestone;
    }    
}