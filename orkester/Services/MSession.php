<?php

namespace Orkester\Services;

use Orkester\Manager;
use Orkester\Services\Exceptions\ETimeoutException;
use Aura\Session\{SessionFactory, Session, Segment};

class MSession
{
    private Session $session;
    private Segment $container;
    private bool $timeout;
    private int $timestamp;

    /**
     * Cada app deve ter seu proprio container para a sessão.
     * MSession constructor.
     * @param string $app
     */
    public function __construct($app = '')
    {
        $sessionFactory = new SessionFactory;
        $this->session = $sessionFactory->newInstance($_COOKIE);
        $this->container = $this->session->getSegment('maestro-session');
        $this->timestamp = 0;
    }

    public function __get($var)
    {
        return $this->container->get($var);
    }

    public function __set($var, $value)
    {
        $this->container->set($var, $value);
    }

    public function init()
    {
        if ($this->timestamp == 0) {
            $this->timestamp = time();
        }
    }

    public function checkTimeout(bool $exception = false): bool
    {
        $timeout = Manager::getConf('session.timeout');
        // If 0, we are not controlling session duration
        if ($timeout != 0) {
            $timestamp = time();
            $difftime = $timestamp - $this->timestamp;
            $this->timeout = ($difftime > ($timeout * 60));
            $this->timestamp = $timestamp;
            if ($this->timeout) {
                $this->session->destroy();
                if ($exception) {
                    throw new ETimeOutException();
                } else {
                    return true;
                }
            }
        }
        return false;
    }

    public function container($namespace)
    {
        return $this->session->getSegment($namespace);
    }

    public function get($var)
    {
        return $this->container->get($var);
    }

    public function set($var, $value)
    {
        $this->container->set($var, $value);
    }

    public function freeze()
    {
        $this->session->commit();
    }

    public function destroy()
    {
        $this->session->destroy();
    }

    public function getValue($var)
    {
        return $this->get($var);
    }

    public function setValue($var, $value)
    {
        $this->set($var, $value);
    }

}
