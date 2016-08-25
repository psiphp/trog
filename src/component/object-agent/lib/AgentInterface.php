<?php

namespace Sycms\Component\ObjectAgent;

interface AgentInterface
{
    /**
     * Save the given object and flush the storage.
     *
     * @param object $object
     */
    public function save($object);

    /**
     * Find an object by its identifier.
     *
     * @param string $identifier
     * @return object
     */
    public function find($identifier);

    /**
     * Return the identifier for the given object.
     *
     * @return string
     */
    public function getIdentifier($object);

    /**
     * Return true if this agent can handle the given object class.
     *
     * @param string $class
     * @return bool
     */
    public function supports($class);

    /**
     * Return the url-safe alias to use for this agent.
     *
     * @return string
     */
    public function getAlias();
}
