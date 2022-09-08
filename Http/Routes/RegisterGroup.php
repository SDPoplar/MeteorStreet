<?php
namespace Mxs\Http\Routes;

class RegisterGroup implements \Stringable
{
    public function setDefault(RegisterItem $def_route)
    {
        $this->def_route = $def_route;
    }

    public function append(array $items)
    {
        $this->all = array_merge($this->all, $items);
    }

    public function __toString(): string
    {
        $def_str = $this->def_route ? '' . $this->def_route : 'null';
        return trim(
<<<compiled_route
<?php
return [
    'default' => {$def_str},
    'routes' => [
        'index' => ['route_id' => '11', 'controller' => '\\App\\Controllers\\Home', 'method' => 'index'],
        'items' => [
            'hello' => [
                'index' => ['route_id' => 'hello', 'controller' => '\\App\\Http\\Controllers\\Home', 'method' => 'hello', 'middlewares' => [\App\Http\Middlewares\Test::class, \App\Http\Middlewares\Another::class]],
                'items' => [
                    'world' => [
                        'index' => ['controller' => '\\App\Controllers\\Home', 'method' => 'test'],
                        'items' => [],
                    ],
                ],
            ],
        ],
        'patterns' => [
            'index' => ['route_id' => 'aa', 'controller' => '\\App\Controllers\\Home', 'method' => 'what', 'route_param_names' => ['action']],
            'items' => [
                'who' => [
                    'index' => ['controller' => '\\App\Controllers\\Home', 'method' => 'fuck', 'route_param_names' => ['action']],
                    'items' => [],
                ],
            ],
        ],
    ],
];
compiled_route
        );
    }

    protected ?RegisterItem $def_route = null;
    protected array $all = [];
}
