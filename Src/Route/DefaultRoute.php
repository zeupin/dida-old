<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Route;

/**
 * 默认模式路由
 */
class DefaultRoute extends \Dida\Route
{
    public function match()
    {
        // 从url路径获取controller和action的原始值
        $controller = (isset($path[0])) ? $path[0] : '';
        $action = (isset($path[1])) ? $path[1] : '';

        // 按照规则进行处理
        if ($controller === '') {
            $controller = DIDA_DEFAULT_CONTROLLER;
            $action = DIDA_DEFAULT_ACTION;
        } else {
            // 把controller转为PascalCase写法
            $controller = $this->usePascalCase($controller);

            // 处理action
            if ($action === '') {
                $action = DIDA_DEFAULT_ACTION;
            } else {
                $action = $this->useCamelCase($action);
            }
        }

        // 如果controller或action含有无效字符，则匹配失败
        if (!dida_is_valid_name($controller) || !dida_is_valid_name($action)) {
            $this->matched = false;
            return false;
        }

        // 如果目标Controller存在，且有此action，则匹配成功
        $class = DIDA_APP_NAMESPACE . '\\Controllers\\' . $controller . 'Controller';
        if (class_exists($class, true)) {
            if ($class::actionExists($action)) {
                // 匹配成功
                $this->controller = $class;
                $this->action = $action;
                $this->parameters = $this->request->query;
                $this->matched = true;
                return true;
            }
        }

        // 否则匹配失败
        $this->matched = false;
        return false;
    }


    /**
     *
     * @param string $controller
     * @param string $action
     * @param array $parameters
     *
     * @return string
     */
    public static function assemble($controller, $action, array $parameters = array())
    {
        $r = [];
        $r[] = "reqr={$controller}/{$action}";
        foreach ($parameters as $k => $v) {
            $r[] = "$k=$v";
        }

        return implode('&', $r);
    }
}
