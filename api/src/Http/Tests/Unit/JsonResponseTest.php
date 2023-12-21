<?php

declare(strict_types=1);

use App\Http\JsonResponse;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class JsonResponseTest extends TestCase
{
    /**
     * @covers  JsonResponse
     */
    public function testInt(): void
    {
        $response = new JsonResponse(12);

        self::assertEquals('12', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }
}
