<?php

namespace App\Http\Controllers\Swagger\Schemas;

/**
 * @OA\SecurityScheme(
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   securityScheme="bearerAuth"
 * )
 *
 * @OA\Schema(schema="typeTimestampNullable", type="string", nullable=true,
 *   example="2024-12-11T13:32:19.000000Z"),
 *
 * @OA\Schema(
 *  schema="errorValidationResponse",
 *  type="object",
 *  required={"errors"},
 *  @OA\Property(property="errors", type="object",
 *    @OA\Property(property="requestParam", type="array", @OA\Items())
 *  )
 * )
 */
class CommonSchemas
{
}
