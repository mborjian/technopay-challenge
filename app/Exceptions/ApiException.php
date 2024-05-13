<?php

namespace App\Exceptions;

use App\Notifications\AdminNotifier;
use App\Services\LogLogger;
use App\Services\MailNotificationSender;
use App\Services\SmsNotificationSender;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiException extends Exception
{
    protected LogLogger $logger;

    public function __construct($message = "Error happened", $code = 500)
    {
        parent::__construct($message, $code);

        $this->logger = new LogLogger();
    }

    /**
     * Handle reporting error to site admin
     * Used config and env for admin contact information
     *
     * @return void
     */
    public function report(): void
    {
        $notifier = new AdminNotifier();

        $notifier->setNotifier(new mailNotificationSender());
        $notifier->send($this->getMessage());

        $notifier->setNotifier(new SmsNotificationSender());
        $notifier->send($this->getMessage());

        $this->logger->error('API Error', ['exception' => $this]);
    }

    /**
     * Respond with a json if user using json content accept and otherwise return error view
     *
     * @param $request
     * @return JsonResponse|Response
     */
    public function render($request): Response|JsonResponse
    {
        if ($request->wantsJson()) {
            return $this->jsonResponse();
        }

        return response()->view('errors.general', ['message' => $this->getMessage()], $this->code);
    }

    /**
     * Create json formatted response
     *
     * @return JsonResponse
     */
    protected function jsonResponse(): JsonResponse
    {
        $response = ['success' => false, 'message' => $this->getMessage()];

        if (config('app.debug')) {
            $response['error'] = [
                'exception' => get_class($this),
                'message' => $this->getMessage(),
                'trace' => $this->getTraceAsString()
            ];
        }

        return response()->json($response, $this->code);
    }
}
