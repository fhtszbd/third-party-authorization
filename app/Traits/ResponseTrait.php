<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * 全局接口返回数据格式
     * @param $data
     * @param string $msg
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data, string $msg, int $code = 200)
    {
        return response()->json(['code' => $code, 'message' => $msg, 'data' => $data ?? []], 200);
    }
}
