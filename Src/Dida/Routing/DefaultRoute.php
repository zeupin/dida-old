<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

use \Dida\Util\String;

/**
 * 默认模式路由
 */
class DefaultRoute extends Route
{
    public function match()
    {
        // 从request中获取路径信息
        $path = $this->request->path;

        // 拆解出controller和action
        $controller = (isset($path[0])) ? $path[0] : '';
        $action = (isset($path[1])) ? $path[1] : '';

        // 按照规则进行处理
        if ($controller === '') {
            $controller = DIDA_DEFAULT_CONTROLLER;
            $action = DIDA_DEFAULT_ACTION;
        } else {
            // 把controller转为PascalCase写法
            $controller = String::toPascalCase($controller);

            // 处理action
            if ($action === '') {
                $action = DIDA_DEFAULT_ACTION;
            } else {
                $action = String::toCamelCase($action);
            }
        }

        // 如果controller或action含有无效字符，则匹配失败
        if (!String::isValidName($controller) || !String::isValidName($action)) {
            $this->matched = false;
            return false;
        }

        // 如果目标Controller存在，且action存在，则匹配成功
        $controllerFQCN = DIDA_APP_NAMESPACE . '\\Controllers\\' . $controller . 'Controller';
        if (class_exists($controllerFQCN, true)) {
            if ($controllerFQCN::actionExists($action)) {
                // 匹配成功
                $this->controller = $controllerFQCN;
                $this->action = $action;
                $this->matched = true;
                return true;
            }
        }

        // 否则匹配失败
        $this->matched = false;
        return false;
    }
}
