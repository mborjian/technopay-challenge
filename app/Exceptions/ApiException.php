<?php

namespace App\Exceptions;


use App\Notifications\ErrorNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ApiException extends Exception
{
    public function __construct($message = "Error processing order", $code = 500)
    {
        parent::__construct($message, $code);
    }

    /**
     * Handle reporting error to site admin
     * Used config and env for admin contact information
     *
     * @return void
     */
    public function report(): void
    {
        Notification::route('mail', config('app.admin_email'))
            ->route('sms', config('app.admin_phone'))
            ->notify(new ErrorNotification($this));
        Log::error('API Error', ['exception' => $this]);
    }

    /**
     * Respond with a json if user using json content accept and otherwise return error view
     *
     * @param $request
     * @return JsonResponse|Response
     */
    public function render($request): JsonResponse|Response
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

