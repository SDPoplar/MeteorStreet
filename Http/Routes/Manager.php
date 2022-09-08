<?php
namespace Mxs\Http\Routes;

class Manager extends \Mxs\Frame\CompileManager
{
    public function __construct(\SeaDrip\Tools\Path $document_root)
    {
        parent::__construct(
            $document_root->merge('routes'),
            $document_root->merge('storage/compiled/routes'),
        );
    }

    public function compile(): bool
    {
        $this->compiled_path->exists() or $this->compiled_path->create();
        if (!$this->compiled_path->isWritable()) {
            var_dump('failed to create route compile path: '.$this->compiled_path);
            return false;
        }
        foreach (glob($this->origin_path . '/*.php') as $route_file) {
            $router = new Register();
            $action = function() use (&$router, $route_file) {
                include ($route_file);
            };
            $action();
            foreach ($router->allGroups() as $g) {
                if (($this->groups[$g] ?? null) === null) {
                    $this->groups[$g] = new RegisterGroup();
                }
                $def = $router->getDefault($g);
                if ($def) {
                    $this->groups[$g]->setDefault();
                }
                $items = $router->getItems($g);
                if (!empty($items)) {
                    $this->groups[$g]->append($items);
                }
            }
        }
        foreach ($this->groups as $group => $data) {
            file_put_contents($this->compiled_path . '/' . $group . '.php', '' . $data);
        }
        return true;
    }

    public function hasCompiled(): bool
    {
        return false;
    }

    public function getCompiled(string $method): Compiled
    {
        return new Compiled($this->compiled_path, \SeaDrip\Enums\HttpMethods::from($method));
    }

    protected $groups = [];
}
