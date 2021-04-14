<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\WeatherRequest;
use App\Models\Weather;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Weather\WeatherClient;
use Illuminate\Support\Facades\Validator;


/**
 * Class WeatherController
 * @package App\Http\Controllers
 */
class WeatherController extends ApiController
{
    /**
     * @return mixed
     */
    public function latest()
    {
        return Weather::paginate();
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function status(Request $request): JsonResponse
    {
        $rules = [
            'type'   => 'required|in:current,forecast,historical',
            'city'   => 'required|string',
            'start'  => 'required_if:type,historical|date_format:Y-m-d',
            'end'    => 'required_if:type,historical|nullable|date_format:Y-m-d'
        ];

        $validator = Validator::make($request->only(array_keys($rules)), $rules);

        if ($validator->fails()) {
            return self::validationError($validator);
        }

        $params = $validator->valid();
        $type = $params['type'];
        unset($params['type']);

        $weatherClient = new WeatherClient(WeatherClient::WEATHERSTACK);
        $response = $weatherClient->{$type}($params);
        return response()->json($response);
    }
}
