<?php



namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class RestResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $status = HttpResponse::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(
        string $message = 'Error',
        int $status = HttpResponse::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    public static function paginated(
        LengthAwarePaginator $paginator,
        mixed $data = null,
        string $message = 'Data fetched successfully.'
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data ?? $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ]);
    }

    public static function validation(
        array $errors,
        string $message = 'Validation failed.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
            errors: $errors
        );
    }

    public static function unauthorized(
        string $message = 'Unauthorized.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: HttpResponse::HTTP_UNAUTHORIZED
        );
    }

    public static function forbidden(
        string $message = 'Permission denied.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: HttpResponse::HTTP_FORBIDDEN
        );
    }

    public static function notFound(
        string $message = 'Resource not found.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: HttpResponse::HTTP_NOT_FOUND
        );
    }

    public static function serverError(
        string $message = 'Something went wrong.'
    ): JsonResponse {
        return self::error(
            message: $message,
            status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public static function created(
        mixed $data = null,
        string $message = 'Created successfully.'
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message,
            status: HttpResponse::HTTP_CREATED
        );
    }

    public static function noContent(): JsonResponse
    {
        return response()->json(null, HttpResponse::HTTP_NO_CONTENT);
    }
}