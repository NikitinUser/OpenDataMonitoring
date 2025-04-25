<?php

namespace App\Http\Controllers\Swagger\Schemas;

/**
 *
 * @OA\Schema (
 *   schema="baseError",
 *   required={"success","message"},
 *   @OA\Property(property="success", type="bool", default=false, example=false),
 *   @OA\Property(property="message", type="string", example="Error message"),
 *   @OA\Property(property="params", type="object", minProperties=1,
 *       additionalProperties=true)
 * )
 *
 * @OA\Schema (schema="errorDetailsItem", type="array",
 *   @OA\Items(type="string",example="Error detailed message")
 * )
 *
 * @OA\Schema (
 *   schema="errorDetails",
 *   required={"errors"},
 *   @OA\Property(property="errors",type="object",
 *     minProperties=1,
 *     additionalProperties=@OA\Schema(ref="#/components/schemas/errorDetailsItem")
 *   )
 * )
 *
 * @OA\Schema (
 *   schema="validationError",
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/baseError"),
 *     @OA\Schema(ref="#/components/schemas/errorDetails")
 *   }
 * )
 *
 * @OA\Response(
 *   response="errorResponseUnauthorized",
 *   description="Unauthorized",
 *   @OA\JsonContent(
 *     ref="#/components/schemas/baseError"
 *   )
 * )
 *
 * @OA\Response(
 *   response="errorResponseBadRequest",
 *   description="Bad request",
 *   @OA\JsonContent(
 *     ref="#/components/schemas/baseError"
 *   )
 * )
 *
 * @OA\Response(
 *   response="errorResponseNotFound",
 *   description="Not Found",
 *   @OA\JsonContent(
 *     ref="#/components/schemas/baseError"
 *   )
 * )
 *
 * @OA\Response(
 *   response="errorResponseForbidden",
 *   description="Forbidden",
 *   @OA\JsonContent(
 *     ref="#/components/schemas/baseError"
 *   )
 * )
 *
 * @OA\Response(
 *    response="errorResponseValidationError",
 *    description="Validation Error Response",
 *    @OA\JsonContent(
 *      ref="#/components/schemas/validationError"
 *    )
 *  )
 */
class ErrorSchemas
{

}
