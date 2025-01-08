<?php

namespace App\Traits;
use App\Models\LogSync;
use App\Models\ConfigApp;
trait ApiResponseTrait
{
    /**
     * Send a JSON response with success message.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function config_app()
    {
        $data = ConfigApp::latest()->first();
        return $data;
    }

    public function log_sync($type,$module)
    {
        $data = LogSync::where('type',$type)->where('module',$module)->latest()->first();
        return $data;
    }

    public function insertLogSync($type,$module)
    {
        $data = array(
            'tanggal'   => date('Y-m-d'),
            'type'      => $type,
            'module'    => $module,
            'sync_by'   => @auth()->user()->id
        );

        LogSync::create($data);
    }

    public function successResponse($code, $data = null, $message = 'Success')
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Send a JSON response with error message.
     *
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($code, $message = 'Error')
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
