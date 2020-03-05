<?php


namespace App;


use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{

    public function recordVisit()
    {
        return Redis::incr($this->visitsCacheKey());
    }

    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        return Redis::del($this->visitsCacheKey());
    }
}
