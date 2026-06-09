    <?php

    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Configuration\Exceptions;
    use Illuminate\Foundation\Configuration\Middleware;

    return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            web: __DIR__ . '/../routes/web.php',
            api: __DIR__ . '/../routes/api.php',
            commands: __DIR__ . '/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware): void {
            $middleware->statefulApi();
            $middleware->alias([
                'role' =>
                \Spatie\Permission\Middleware\RoleMiddleware::class,
            ]);
        })
        ->withExceptions(function (Exceptions $exceptions): void {

            $exceptions->render(function (
                Throwable $e,
                $request
            ) {

                if ($request->is('api/*')) {

                    // ==========================
                    // VALIDATION ERROR
                    // ==========================
                    if (
                        $e instanceof
                        \Illuminate\Validation\ValidationException
                    ) {

                        return response()->json([
                            'success' => false,
                            'message' =>
                            'Validation Error',

                            'errors' =>
                            $e->errors()
                        ], 422);
                    }

                    // ==========================
                    // HTTP ERROR
                    // ==========================
                    if (
                        $e instanceof
                        \Symfony\Component\HttpKernel\Exception\HttpException
                    ) {

                        return response()->json([
                            'success' => false,

                            'message' =>
                            $e->getMessage()
                                ?: match ($e->getStatusCode()) {

                                    401 =>
                                    'Unauthorized',

                                    403 =>
                                    'Forbidden',

                                    404 =>
                                    'Resource not found',

                                    default =>
                                    'Something went wrong'
                                }
                        ], $e->getStatusCode());
                    }

                    // ==========================
                    // DEVELOPMENT ERROR
                    // ==========================
                    if (
                        config('app.debug')
                    ) {

                        return response()->json([
                            'success' => false,

                            'message' =>
                            $e->getMessage(),

                            'file' =>
                            basename(
                                $e->getFile()
                            ),

                            'line' =>
                            $e->getLine(),

                            'trace' =>
                            collect(
                                $e->getTrace()
                            )->take(5)
                        ], 500);
                    }

                    // ==========================
                    // PRODUCTION
                    // ==========================
                    return response()->json([
                        'success' => false,
                        'message' =>
                        'Internal Server Error'
                    ], 500);
                }
            });
        })->create();
