<?php

namespace Palmbuy\Log;

use App\Common\IdGenerator\Uuid;
use Carbon\Carbon;
use Closure;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Wufly\Log\Jobs\SaveLogJob;
use Wufly\Log\Request;
use Illuminate\Support\Facades\Config;
use Wufly\Logstash;

class RequestAndResponseLog implements MiddlewareInterface
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!config('requestLog.enabled')) {
            return $handler->handle($request);
        }
//        $request = ApplicationContext::getContainer()->get(\Hyperf\HttpServer\Contract\RequestInterface::class);
        $requestId = $request->getHeader(config('requestLog.request_id_name'));
        if (!$requestId) {
            $requestId = make(Uuid::class)->setPrefix('req')->generate();
        }
        // 请求url
        $url = $request->fullUrl();
        // 请求方法
        $method = $request->getMethod();
        // 获取请求的header头
        $request_headers = $request->getHeaders();
        // 获取请求的body
        $request_data = $request->getBody();

        // 添加requestId
        $response = $handler->handle($request);

        // 获取响应的状态
        $status = $response->getStatusCode();
        // 获取响应的header头
//        $response_headers = $response->headers->all();
        $response_headers = $response->getHeaders();
        // 获取响应的数据
        $response_data = $response->getBody()->getContents();

        $data = [
            'request_id' => $requestId,
            'request_url' => $url,
            'method' => $method,
            'request_headers' => json_encode($request_headers),
            'request_data' => json_encode($request_data),
            'response_status' => $status,
            'response_headers' => json_encode($response_headers),
            'response_data' => $response_data,
            'created_at' => Carbon::now()->toDateTimeString(),
        ];
        Logstash::channel('request-and-response-log')->info('', $data);

        if (config('requestLog.table.save')) {
            SaveLogJob::dispatch($data);
        }
        return $response;
    }
}
