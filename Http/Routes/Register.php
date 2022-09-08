<?php
namespace Mxs\Http\Routes;

class Register
{
    public function allGroups(): array
    {
        return array_unique(array_merge(array_keys($this->all), array_keys($this->def_routes)));
    }

    public function getDefault(string $group): ?RegisterItem
    {
        return $this->def_routes[$group] ?? null;
    }

    public function getItems(string $group): array
    {
        return $this->all[$group] ?? [];
    }

    public function &def(string $method): RegisterItem
    {
        $this->def_routes[$method] = new RegisterItem($method, 'def');
        return $this->def_routes[$method];
    }

    public function &get(string $url)
    {
        return $this->group('get', $url);
    }

    public function &post(string $url)
    {
        return $this->group('post', $url);
    }

    protected function &group(string $group, string $url): RegisterItem
    {
        if (is_array($this->all[$group] ?? null)) {
            $this->all[$group] = [];
        }
        $this->all[$group][] = new RegisterItem($group, $url);
        return $this->all[$group][count($this->all[$group]) - 1];
    }

    protected array $all = [];
    protected array $def_routes = [];
}
