<?php


namespace Orkester\Exception;


class EValidationException extends BaseException
{
    public array $errors;

    public function __construct($errors)
    {
        parent::__construct('Validation Error', 400);
        $this->errors = $errors;
    }
}
