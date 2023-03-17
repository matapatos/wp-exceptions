<?php

/**
 * Response used when an http exception is thrown during a regular request.
 *
 * @version 1.0.0
 * @author matapatos
 * @package wp-exceptions
 * @uses roots/acorn
 */

declare(strict_types=1);

namespace WP\Exceptions\Responses;

use Symfony\Component\HttpFoundation\Response;
use WP_Http;

class HtmlResponse extends Response implements ResponseInterface
{
    /**
     * @version 1.0.0
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     */
    public function __construct(
        ?string $message = '',
        ?int $status = WP_Http::INTERNAL_SERVER_ERROR,
        array $data = [],
        array $headers = []
    ) {
        $headers = array_merge(['Content-Type' => 'text/html'], $headers);
        $content = $this->getResponseContent($message, $status, $data);
        parent::__construct($content, $status, $headers);
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
    ): ?string {
        $templateView = apply_filters('html_response_view_name', 'error');
        if (!$templateView) {
            return $message;
        }


        if (!view()->exists($templateView)) {
            wp_die(sprintf(esc_html__('Unable to find error view %s'), $templateView));
        }

        $args = apply_filters('html_response_view_args', [
            'title'         => 'Something went wrong',
            'errorMessage'  => $message,
            'httpStatus'    => $status,
            'data'          => $data,
        ]);
        // Avoid issues when rendering http errors in wp-admin requests
        if (is_admin()) {
            $isToShowAdminBar = apply_filters('show_admin_bar', true);
            set_current_screen($isToShowAdminBar ? '' : 'front');
        }
        return view($templateView, $args)->render();
    }
}
