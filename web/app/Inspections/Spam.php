<?php

namespace App\Inspections;

use Exception;

class Spam
{

    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inpection){
            app($inpection)->detect($body);
        }
        return false;
    }

}
