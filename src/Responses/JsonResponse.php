<?php

/**
 * Response used when an http exception is thrown during a REST request.
 *
 * @version 1.0.0
 * @author matapatos
 * @package wp-exceptions
 */

declare(strict_types=1);

namespace Wp\Exceptions\Responses;

use Illuminate\Http\JsonResponse as HttpJsonResponse;
use WP_Http;

class JsonResponse extends HttpJsonResponse
{
    /**
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     */
    public function __construct(
        ?string $message = '',
        ?int $status = WP_Http::INTERNAL_SERVER_ERROR,
        array $data = [],
        array $headers = [],
        $options = 0,
        $json = false
    ) {
        $content = $this->getResponseContent($message, $status, $data);
        parent::__construct($content, $status, $headers, $options, $json);
    }

    /**
     * Retrieves a properly formated json response
     *
     * @version 1.0.0
     */
    public function getResponseContent(
        ?string $message = '',
        ?int $status = WP_Http::INTERNAL_SERVER_ERROR,
        array $data = []
    ) {
        $content = [
            'message'   => esc_html__($message),
            'code'      => $status,
        ];
        if ($data) {
            $content['data'] = $data;
        }

        return $content;
    }
}
