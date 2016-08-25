<?php

namespace Sycms\Component\ObjectAgent\Tests;

use Sycms\Component\ObjectAgent\AgentInterface;
use Sycms\Component\ObjectAgent\AgentFinder;

class AgentFinderTest extends \PHPUnit_Framework_TestCase
{
    private $finder;

    public function setUp()
    {
        $this->agent1 = $this->prophesize(AgentInterface::class);
        $this->agent2 = $this->prophesize(AgentInterface::class);
        $this->finder = new AgentFinder([
            $this->agent1->reveal(),
            $this->agent2->reveal(),
        ]);
    }

    /**
     * It should return an agent that supports the given object class.
     */
    public function testFindAgent()
    {
        $this->agent1->supports(\stdClass::class)->willReturn(false);
        $this->agent2->supports(\stdClass::class)->willReturn(true);

        $agent = $this->finder->findAgentFor(\stdClass::class);
        $this->assertSame($this->agent2->reveal(), $agent);
    }

    /**
     * It should throw an exception if no agents support the given class.
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Could not find an agent supporting class "stdClass".
     */
    public function testFindAgentNotFound()
    {
        $this->agent1->supports(\stdClass::class)->willReturn(false);
        $this->agent2->supports(\stdClass::class)->willReturn(false);

        $agent = $this->finder->findAgentFor(\stdClass::class);
        $this->assertSame($this->agent2->reveal(), $agent);
    }

}
