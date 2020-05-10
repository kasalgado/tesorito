<?php declare (strict_types=1);

namespace App\Utils;

use Symfony\Contracts\Translation\TranslatorInterface;

class WeekDays
{
    private $translator;
    
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator= $translator;
    }
    
    public function get(): array
    {
        return [
            $this->translator->trans('sunday'),
            $this->translator->trans('monday'),
            $this->translator->trans('tuesday'),
            $this->translator->trans('wednesday'),
            $this->translator->trans('thursday'),
            $this->translator->trans('friday'),
            $this->translator->trans('saturday'),
        ];
    }
}
