<?php

namespace Trog\Component\ObjectAgent;

class AgentFinder
{
    private $agents;

    public function __construct(array $agents)
    {
        $this->agents = $agents;
    }

    public function findAgentFor($class)
    {
        foreach ($this->agents as $agent) {
            if ($agent->supports($class)) {
                return $agent;
            }
        }

        $classes = array_map(function ($element) {
            return get_class($element);
        }, $this->agents);

        throw new \InvalidArgumentException(sprintf(
            'Could not find an agent supporting class "%s". Registered agents: "%s"',
            $class, implode('", "', $classes)
        ));
    }

    public function getAgent($alias)
    {
        if (!isset($this->agents[$alias])) {
            throw new \InvalidArgumentException(sprintf(
                'Agent "%s" has not been registered, known agents: "%s"',
                $alias, implode('", "', array_keys($this->agents))
            ));
        }

        return $this->agents[$alias];
    }
}
