<?php
namespace Mxs\Gate;

use SeaDrip\Http\Method as EHttpMethod;
use Mxs\Routes\{
    Rule,
    RuleGroup,
};

abstract class Route
{
    public static function setCurrentFile(string $file_path): void
    {
        self::$current_file = $file_path;
    }

    public static function enumMethods(): array
    {
        $ret = [];
        foreach(self::allRules() as $item) {
            $ret[$item->method] = true;
        }
        return array_keys($ret);
    }

    public static function getRulesByMethod(string $method): array
    {
        return array_filter(self::allRules(), fn(Rule $item): bool => $item->method === $method);
    }

    public static function clearRegisted()
    {
        self::$registed = [];
    }

    public static function &group(callable $regist_func): RuleGroup
    {
        $group_instance = new RuleGroup($regist_func);
        self::$groups[] =& $group_instance;
        return $group_instance;
    }

    public static function &get(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::GET->value, $path, $controller_class, $method_name);
    }

    public static function &post(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::POST->value, $path, $controller_class, $method_name);
    }

    public static function &put(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::PUT->value, $path, $controller_class, $method_name);
    }

    public static function &head(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::HEAD->value, $path, $controller_class, $method_name);
    }

    public static function &opetions(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::OPTIONS->value, $path, $controller_class, $method_name);
    }

    public static function &delete(string $path, string $controller_class, string $method_name): Rule
    {
        return self::rule(EHttpMethod::DELETE->value, $path, $controller_class, $method_name);
    }

    public static function &command(string $controller_class): Rule
    {
        return self::rule(\Mxs\Modes\Console::METHOD, $controller_class::getUsage(), $controller_class, 'handle');
    }

    private static function &rule(string $method, string $path, string $controller_class, string $method_name): Rule
    {
        $rule_instance = new Rule(self::$current_file, $method, $path, $controller_class, $method_name);
        if (!is_null(self::$grouping)) {
            $rule_instance->middware(...self::$grouping->getRegistedMiddlewares());
        }
        self::$registed[] =& $rule_instance;
        return $rule_instance;
    }

    private static function allRules(): array
    {
        if (!is_null(self::$grouping)) {
            throw new \Mxs\Exceptions\Develops\RouteGroupNotClosed(self::$current_file);
        }
        while (!empty(self::$groups)) {
            $group = array_shift(self::$groups);
            self::$grouping = $group;
            $group->compile();
            self::$grouping = null;
        }
        return self::$registed;
    }

    protected static array $registed = [];
    protected static array $groups = [];
    protected static ?RuleGroup $grouping = null;
    protected static string $current_file = '';
}