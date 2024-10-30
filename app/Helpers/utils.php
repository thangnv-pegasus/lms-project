<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

function responseBase($http_status, $data = [], $msg = '', $pagination = null)
{
    $result = [
        'msg' => $msg,
        'data' => $data,
    ];

    if(isset($pagination)) {
        $result['pagination'] = $pagination;
    }

    return response()->json($result, $http_status);
}

function responseError($code, $data = new stdClass())
{
    $api_errors = config('constants.api_errors');

    $msg = $api_errors[$code]['msg'];
    $http_status = $api_errors[$code]['http_status'];

    return responseBase($http_status, $data, $msg);
}

function responseOK($data = new stdClass(), $pagination = null, $msg = '成功。')
{
    return responseBase(200, $data, $msg, $pagination);
}

function storagePath($path) {
    return config('config.app.app_url') . $path;
}

function getOnlyFileName($file_name) {
    return substr($file_name, 0, strpos($file_name, "."));
}

function numberToStringPad($string, $toString = false , $padLength = 7, $padString = '0') {
    return ($toString ? "'" : '') . str_pad($string, $padLength, $padString, STR_PAD_LEFT);
}

function paginationFormat($data, $getting_type = null) {
    if($getting_type == 'all') {
        return null;
    }

    $paginate = [];
    $paginate = [
        'current_page' => $data->currentPage(),
        'total' => $data->total(),
        'per_page' => $data->perPage(),
        'next_page_url' => $data->nextPageUrl() ?? '',
        'first_item' => $data->firstItem(),
        'last_item' => $data->lastItem()
    ];

    return $paginate;
}



function getResetPasswordToken($email)
{
    return base64_encode($email . config('constants.admin_reset_password_token_prefix') . (time() + (int) config('constants.admin_reset_password_token_expired_time')));
}

function getResetPasswordTokenKite($email)
{
    return base64_encode($email . config('constants.admin_reset_password_token_prefix') . (time() + (int) config('constants.kite_reset_password_token_expired_time')));
}

function formatTime($time) {
    return $time->format('Y-m-d H:i');
}

function getMessageValidationByField($fieldName, $ruleName) {
    try {
        $fields = config('constants.validations.fields');
        $messages = config('constants.validations.messages');
        $fieldLabel = $fields[$fieldName];
        return sprintf($messages[$ruleName], $fieldLabel, $fieldLabel);
    } catch (\Exception $e) {
        return config('constants.validations.messages.default');
    }
}

function data_url_encode($input)
{
    return bin2hex(base64_encode($input));
}

function data_url_decode($input)
{
    return base64_decode(hex2bin($input));
}

function generate_token()
{
    return hash("sha256", rand());
}

function convertUrlToFilePath($url) {
    return ltrim(parse_url($url)['path'], '/');
}

function uploadFile($file, $folder, $keepFileName = false, $newFileName = null, $options = 'public') {
    try {
        // if (!Storage::exists($folder)) {
        //     Storage::makeDirectory($folder);
        // }
        if($keepFileName) {
            $fileName = $file->getClientOriginalName();
            $result = Storage::putFileAs($folder, $file,$fileName, $options);
        } elseif($newFileName) {
            $result = Storage::putFileAs($folder, $file,$newFileName, $options);
        } else {
            $result = Storage::put($folder, $file, $options);
        }

        if(!$result) {
            throw new \Exception('Upload failed!');
        }
        return $result;
    } catch (\Exception $e) {
        throw $e;
    }
}

function deleteFile($file) {
    try {
        if ($file && Storage::exists($file)) {
            return Storage::delete($file);
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

function deleteMultiFile($files) {
    try {
        return Storage::delete(array_filter($files, function($item) {
            return !is_null($item);
        }));
    } catch (\Exception $e) {

        throw $e;
    }
}

function filterChartsByType($arr, $type, $options = null) {
    switch ($type) {
        case 1: // For sort by array $options
            $result = [];
            foreach($options as $label) {
                $result[$label] = $arr[$label] ?? 0;
            }

            return $result;
        case 2: // For convert to array with item [name, value]
            $result = [];
            arsort($arr);
            foreach($arr as $key => $value) {
                $result[] = [
                    'name' => $key,
                    'value' => $value,
                ];
            }
            return $result;
        default:
            return $arr;
    }
}

/**
 * @param $key
 * @param $label
 * @param $collection
 * @return string String
 */
function findUserValueByKey($key, $label, $collection) {
    $firstItem = $collection?->first();

    switch ($key) {
        case 'created_at';
            return $firstItem?->created_at ?? '';
        case 'code';
        case 'status';
        case 'cancelled_at';
            return $firstItem?->user?->$key ?? '';
        case 'form_id';
            return $firstItem?->form_key?->form?->id ?? '';
        case 'form_name';
            return $firstItem?->form_key?->form?->name ?? '';
        case 'event_id';
            return $firstItem?->form_key?->form?->event?->id ?? '';
        case 'first_name';
        case 'last_name';
        case 'first_name_furi';
        case 'last_name_furi';
        case 'email';
        case 'code_customer';
        case 'affiliated_organization_name';
        case 'post_code';
        case 'address_below';
        case 'source_of_seminar_other';
        case 'number_dog';
        case 'number_cat';
        case 'is_annual_sales';
        case 'question';
            return $collection?->first(function($item) use ($key) {
                return $item?->form_key?->key?->key === $key;
            })?->value ?? '';
        case 'address';
        case 'status_rcp';
        case 'register_class';
        case 'is_shell';
        case 'pro_club_registration_status';
            $userValue = $collection?->first(function($item) use ($key) {
                return $item?->form_key?->key?->key === $key;
            });
            $value = $userValue?->value;
            return $userValue?->form_key?->key?->keys->first(function($item) use ($value) {
                return $item->id == $value;
            })?->name ?? '';
        case 'source_of_seminar_royal_canin_email';
        case 'source_of_seminar_sales_info';
        case 'source_of_seminar_external_communication';
        case 'source_of_seminar_internal_info';
        case 'source_of_seminar_is_other';
            $key = 'source_of_seminar';
            $userValuesSelected = $collection?->filter(function($item) use ($key) {
                return $item?->form_key?->key?->key === $key;
            });

            $hasSelected = false;
            if($userValuesSelected->count()) {
                $options = $keyOptions = $userValuesSelected?->first()->form_key?->key?->keys;

                $keySelected = $options->first(function($item) use($label) {
                    return $item->name === $label;
                });

                if($keySelected) {
                    $userValueItemSelected = $userValuesSelected->first(function($item) use($keySelected) {
                        return $item->value == $keySelected->id;
                    });
                    $hasSelected = $userValueItemSelected ?? false;
                }
            }

            return $hasSelected ? config('constants.events.exports.label_by_types.checked') : config('constants.events.exports.label_by_types.not_check');
        default:
            return config('constants.events.exports.label_by_types.checked');
    }
}

/**
 * Generate date range
 *
 * @param $startDate
 * @param $endDate
 * @return array
 */
function generateDateRange($startDate, $endDate) {
    $start = \Carbon\Carbon::parse($startDate);
    $end = \Carbon\Carbon::parse($endDate);
    $dates = [];

    for ($date = $start; $date->lte($end); $date->addDay()) {
        $dates[$date->format('Y-m-d')] = $date->format('Y-m-d');
    }

    return $dates;
}

/**
 * Add data to array
 *
 * @param $array
 * @param $data
 * @return mixed
 */
function addDataToArray($array, $data) {
    foreach($array as $field => &$value) {
        $value = $data[$field] ?? 0;
    }
    return $array;
}

/**
 * Download file with path
 *
 * @param $filePath
 * @param null $fileName
 * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\StreamedResponse
 */
function downloadFile($filePath, $fileName = null) {

    if (!Storage::exists($filePath)) {
        return responseError(433);
    }

    return Storage::download($filePath, $fileName);
}

/**
 * @param $filePath
 * @return bool
 */
function existFile($filePath) {
    return Storage::exists($filePath);
}

/**
 * Collection count by conditions
 *
 * @param $collections
 * @param array $conditions
 * @return mixed
 */
function collectionCount($collections, $conditions = [])
{
    foreach($conditions as $field => $value) {
        $collections = $collections->where($field, $value);
    }
    return $collections->count();
}

function valueCount($array) {
    $dateCounts = [];
    foreach ($array as $key => $date) {
        if (isset($dateCounts[$date])) {
            $dateCounts[$date]++;
        } else {
            $dateCounts[$date] = 1;
        }
    }
    return $dateCounts;
}

function getEncodedS3Url($filePath) {
    if(config('filesystems.default') === 's3') {
        $s3Config = config('filesystems.disks.s3');
        $bucket = $s3Config['bucket'];
        $region = $s3Config['region'];
        $scheme = isset($s3Config['url']) ? parse_url($s3Config['url'], PHP_URL_SCHEME) : 'https';

        $baseUrl = $scheme . '://' . $bucket . '.s3.' . $region . '.amazonaws.com/';
        return $baseUrl . $filePath;
    } else {
        return Storage::url($filePath);
    }
}

function emailFromRequestUri($queryString) {
    $params = explode('&', $queryString);
    $email = null;

    foreach ($params as $param) {
        $parts = explode('=', $param);

        if ($parts[0] === 'email') {
            $email = $parts[1];
            break;
        }
    }
    return $email;
}

function getDayByDate($date, $isJapanese = true) {
    $date = \Carbon\Carbon::parse($date);
    $dayNumber = $date->dayOfWeekIso;
    if($isJapanese) {
        $daysJapanese = config('constants.days_of_week.japaneses.compact');
        return $daysJapanese[$dayNumber] ?? '';
    }
    return $dayNumber;
}

function findClosestOrInRange($currentTime, $dates, $fieldNameStartTime = 'start_time', $fieldNameEndTime = 'end_time') {
    $closest = null;
    $minDiff = PHP_INT_MAX;

    foreach ($dates as $date) {
        $startTime = strtotime($date[$fieldNameStartTime]);
        $endTime = strtotime($date[$fieldNameEndTime]);
        $current = strtotime($currentTime);

        if ($current >= $startTime && $current <= $endTime) {
            return $date;
        }

        $diff = abs($startTime - $current);

        if ($diff < $minDiff) {
            $minDiff = $diff;
            $closest = $date;
        }
    }

    return $closest;
}

function checkElementContainInArray($collection1, $collection2) {
    return $collection1->every(function ($value) use ($collection2) {
        return $collection2->contains($value);
    });
}

function authKite()
{
    return auth()->guard('kite')->user();
}
