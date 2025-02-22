<?php

namespace App\Foundations\Routing;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends LaravelController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Prepare api response.
     *
     * @return Formatter
     */
    public function formatter(): Formatter
    {
        return Formatter::factory();
    }

    /**
     * Return the api response.
     *
     * @param array $data
     * @param int $totCnt
     * @param bool $wantInfo
     * @param int $status
     * @return JsonResponse
     */
    public function response(array $data = [], int $totCnt = 0, bool $wantInfo = false, int $status = 200): JsonResponse
    {
        return response()->json(Formatter::factory()->make($data, $totCnt, $wantInfo))->setStatusCode($status);
    }

    public function nullResp(): JsonResponse
    {
        $default = $this->formatter()->defaultFormat();

        $default['data'] = null;

        return response()->json($default);
    }

    public function withCustomDataResp(array $data = [], string $newDataKey = null, array $newData = []): JsonResponse
    {
        if (empty($newData)) {
            return $this->response($data);
        }

        $default = $this->formatter()->make($data);

        if (!empty($newDataKey)) {
            $default[$newDataKey] = $newData;
        }

        return response()->json($default);
    }

    /**
     * @param string $uuid
     * @return string
     */
    public function destroyMsg(string $uuid): string
    {
        return "The requested ID: {$uuid} was deleted.";
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function msgResponse($message, $code = 200): JsonResponse
    {
        return response()->json($this->makeMsgResponse($message,$code))->setStatusCode($code);
    }

    /**
     * @param $message
     * @param int $code
     * @return array
     */
    public function makeMsgResponse($message, $code = 200): array
    {
        return $this->formatter()->setMessage($message)->setStatus($code)->make();
    }
}
