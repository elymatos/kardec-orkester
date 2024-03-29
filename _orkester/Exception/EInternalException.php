<?php

namespace Orkester\Services\Exceptions;

/**
 * Engloba exceções onde a mensagem original deve ser oculta do usuário.
 */
class EInternalException extends \Exception
{

    public function __construct(\Exception $original, $messageId = 'error')
    {
        parent::__construct(
            $this->message = $messageId,
            $original->getCode(),
            $original
        );

        $this->dump();
    }

    private function dump()
    {
        $msg = '{{' . get_class($this->getPrevious()) . '}} ';
        $msg .= $this->getPrevious()->getMessage();
        $msg .= ' [File] ' . $this->getPrevious()->getFile();
        $msg .= ' [Line] ' . $this->getPrevious()->getLine();
        mdump($msg, 'error');
    }
}