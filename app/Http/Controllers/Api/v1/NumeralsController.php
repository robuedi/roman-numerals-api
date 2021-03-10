<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Requests\Api\v1\ConvertRomanRequest;
use App\Http\Requests\Api\v1\IndexRequest;
use App\Http\Requests\Api\v1\Top10Request;
use App\Http\Resources\v1\NumberConversionsResource;
use App\Repositories\NumberConversionsRepositoryInterface;
use App\Services\NumericConverter\NumericConverterInterface;
use Illuminate\Http\Response;

class NumeralsController
{
    use ApiResponse;

    private NumberConversionsRepositoryInterface $number_conversions_repository;

    public function __construct(NumberConversionsRepositoryInterface $number_conversions_repository)
    {
        $this->number_conversions_repository = $number_conversions_repository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/numerals",
     *      operationId="index",
     *      tags={"Numerals"},
     *      summary="Get/Paginate the list of numeral conversions",
     *      description="Get/Paginate the list of numeral conversions",
     *     @OA\Parameter(
     *          name="fields",
     *          description="the list of fields to be included (comma separated)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="order_by",
     *          description="the column by which the records to be sorted",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="sort_by",
     *          description="the direction by which the records to be sorted: ASC-DESC",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent()
     *       ),
     *       security={}
     *     )
     *
     * Returns list of numeral conversions
     */
    public function index(IndexRequest $request)
    {
        return NumberConversionsResource::collection($this->number_conversions_repository->index([
            'fields' => $request->get('fields'),
            'sort_by' => $request->get('sort_by'),
            'order_by' => $request->get('order_by'),
        ], true))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\POST(
     *      path="/api/v1/numerals/convert-roman",
     *      operationId="convert-roman",
     *      tags={"Numerals"},
     *      summary="Convert integer to roman",
     *      description="Convert integer to roman",
     *     @OA\Parameter(
     *          name="value",
     *          description="integer value",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="unsuccessful operation, missing field value",
     *          @OA\JsonContent()
     *       ),
     *       security={}
     *     )
     *
     * Convert integer to roman
     */
    public function convertRoman(ConvertRomanRequest $request, NumericConverterInterface $numeric_converter)
    {
        //increment the counter for the value
        $this->number_conversions_repository->incrementForValue($request->get('value'));

        return $this->apiResponse([
            //make conversion
            'value' => $numeric_converter->convertToRoman($request->get('value'))
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/numerals/top-10",
     *      operationId="top10",
     *      tags={"Numerals"},
     *      summary="Get the list of top 10 numeral conversions",
     *      description="Get the list of top 10 numeral conversions",
     *     @OA\Parameter(
     *          name="fields",
     *          description="the list of fields to be included (comma separated)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent()
     *       ),
     *       security={}
     *     )
     *
     * Returns list of numeral conversions
     */
    public function top10(Top10Request $request)
    {
        return NumberConversionsResource::collection($this->number_conversions_repository->index([
            'fields'    => $request->get('fields'),
            'sort_by'   => 'count',
            'order_by'  => 'DESC',
            'limit'     => 10,
        ], false))->response()->setStatusCode(Response::HTTP_OK);
    }
}
