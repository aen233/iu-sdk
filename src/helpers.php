<?php
/**
 * Created by PhpStorm.
 * User: qian
 * Date: 2018/12/10
 * Time: 19:24
 */

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (!function_exists('getSql')) {
    /**
     * 获取执行sql
     *
     * @param $query
     *
     * @return string
     */
    function getSql($query)
    {
        $sql = str_replace("?", "'%s'", $query->toSql());

        return vsprintf($sql, $query->getBindings());
    }
}

if (!function_exists('iuLog')) {
    /**
     * @param        $level
     * @param        $desc
     * @param array  $data
     * @param string $filename
     */
    function iuLog($level, $desc = '', $data = [], $filename = '')
    {
        $module    = Str::title(substr(request()->path(), 0, strpos(request()->path(), '/')));
        $moduleArr = Arr::where(scandir(base_path('modules')), function ($value) {
            return !Str::startsWith($value, '.');
        });

        $logPath = in_array($module, $moduleArr)
            ? base_path('modules/') . $module . '/Logs/' . date('Y/m/')
            : storage_path() . '/logs/' . date('Y/m/');

        if (!file_exists($logPath)) {
            mkdir($logPath, 0777, true);
        }
        $filename = $filename ?: date('d');
        // 记录日志

        $dir = $logPath . $filename . '.log';

        if ($level == PHP_EOL) {
            if ($desc ?? '') {
                $dir = $logPath . $desc . '.log';
            }
            file_put_contents($dir, PHP_EOL, FILE_APPEND);

            return;
        }

        $prefix = '[' . now() . '] ' . app()->environment() . '.' . strtoupper($level) . ': ';

        if (!$data) {
            file_put_contents($dir, $prefix . $desc . PHP_EOL, FILE_APPEND);

            return;
        }
        //            JSON_UNESCAPED_UNICODE（中文不转为unicode ，对应的数字 256）
        //            JSON_UNESCAPED_SLASHES（不转义反斜杠，对应的数字 64）
        //            JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES = 320
        file_put_contents($dir, $prefix . $desc . json_encode($data, 320) . PHP_EOL, FILE_APPEND);
    }
}
