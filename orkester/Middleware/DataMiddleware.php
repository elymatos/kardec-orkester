<?php
declare(strict_types=1);

namespace Orkester\Middleware;

use Orkester\Manager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class DataMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        mtrace('in data middleware');
        $data =  (object)$request->getQueryParams();
        $body = $request->getParsedBody() ?? [];
        foreach($body as $name => $value){
            $data->$name = $value;
        }
        $this->setData($data);
        $response = $handler->handle($request);
        return $response;
    }

    public function setPrimeVueFilters($data, $filters): bool
    {
        $data->filter = [];
        foreach ($filters as $field => $condition) {
            ['value' => $value, 'matchMode' => $matchMode] = $condition;
            if (empty($value)) continue;
            array_push($data->filter,
                match ($matchMode) {
                    'startsWith' => [$field, 'LIKE', "$value%"],
                    'contains' => [$field, 'LIKE', "%$value%"],
                    'endsWith' => [$field, 'LIKE', "%$value"],
                    'notContains' => [$field, 'NOT LIKE', "%$value%"],
                    'notEquals' => [$field, '<>', $value],
                    default => [$field, '=', $value]
                });
        }
        return true;
    }

    private function setData($values)
    {
        $data = new \stdClass;;
        $valid = (is_object($values)) || (is_array($values) && count($values));
        if ($valid) {
            foreach ($values as $name => $value) {
                // handle _ or _* : https://github.com/typicode/json-server
                if (($name[0] == '_') || ($name == '_')) {
                    $data->pagination = $data->pagination ?? (object)[];
                    $data->relationship = $data->relationship ?? (object)[];
                    match($name) {
                        '_page' => $data->pagination->page = $value,
                        '_limit' => $data->pagination->rows = $value,
                        '_sort' => $data->pagination->sort = $value,
                        '_order' => $data->pagination->order = $value == -1 ? 'desc' : 'asc',
                        '_start' => $data->pagination->start = $value,
                        '_end' => $data->pagination->end = $value,
                        '_embed' => $data->relationship->embed = $value,
                        '_expand' => $data->relationship->expand = $value,
                        '_filter' => $this->setPrimeVueFilters($data, $value), // primevue
                        default => '',
                    };
                } else {
                    // handle Json
                    if (isJson($value) && (strpos($value, 'json:') === 0)) {
                        $value = json_decode(substr($value, 5));
                    }
                    // handle object::attr and object_attr
                    if (str_contains($name, '::')) {
                        list($obj, $name) = explode('::', $name);
                        if ($data->{$obj} == '') {
                            $data->{$obj} = (object)[];
                        }
                        $data->{$obj}->{$name} = $value;
                    } else {
                        $data->{$name} = $value;
                    }
                }
            }
        }
        Manager::setData($data);
    }


}
