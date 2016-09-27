<?php

namespace Trog\Component\ContentType\Model;

class PublishPeriod
{
    private $id;
    private $start;
    private $end;

    public function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getStart() 
    {
        return $this->start;
    }
    
    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd() 
    {
        return $this->end;
    }
    
    public function setEnd($end)
    {
        $this->end = $end;
    }
}
