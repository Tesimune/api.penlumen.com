<?php

namespace App\Http\Controllers\Api\V1;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Drive Endpoint.
 *
 */
class DriveController extends Controller
{
    /**
     * List documents.
     *
     */
    public function index($lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $token = $user->socialite->token;

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Failed, No Google Drive linked',
                'data' => [
                    'message' => 'Failed, No Google Drive linked',
                ]
            ]);
        }

        $client = new Google_Client();
        $client->setAccessToken($token);

        $service = new Google_Service_Drive($client);

        $files = $service->files->listFiles([
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name, mimeType)'
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Success',
            'data' => [
                'message' => 'Success',
                'files' => $files->getFiles()
            ]
        ]);
    }

    /**
     * Show document.
     *
     */
    public function show($id, $lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $token = $user->socialite->token;

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Failed',
                'data' => [
                    'message' => 'Failed',
                ]
            ]);
        }

        $client = new Google_Client();
        $client->setAccessToken($token);

        $service = new Google_Service_Drive($client);

        $file = $service->files->get($id, ['alt' => 'media']);
        $content = $file->getBody()->getContents();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Success',
            'data' => [
                'message' => 'Success',
                'content' => $content
            ]
        ]);
    }

    /**
     * Create document.
     *
     */
    public function create(Request $request, $lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $token = $user->socialite->token;

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Failed',
                'data' => [
                    'message' => 'Failed',
                ]
            ]);
        }

        $client = new Google_Client();
        $client->setAccessToken($token);

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $request->input('name')
        ]);

        $content = $request->input('content');

        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'text/html',
            'uploadType' => 'multipart'
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'File created successfully',
            'data' => $file
        ]);
    }

    /**
     * Update document.
     *
     */
    public function update(Request $request, $id, $lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $token = $user->socialite->token;

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Failed',
                'data' => [
                    'message' => 'Failed',
                ]
            ]);
        }

        $client = new Google_Client();
        $client->setAccessToken($token);

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $request->input('name')
        ]);

        $content = $request->input('content');

        $file = $service->files->update($id, $fileMetadata, [
            'data' => $content,
            'mimeType' => 'text/html',
            'uploadType' => 'multipart'
        ]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'File updated successfully',
            'data' => $file
        ]);
    }

    /**
     * Delete document.
     *
     */
    public function delete($id, $lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $token = $user->socialite->token;

        if (!$token) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Failed',
                'data' => [
                    'message' => 'Failed',
                ]
            ]);
        }

        $client = new Google_Client();
        $client->setAccessToken($token);

        $service = new Google_Service_Drive($client);

        $service->files->delete($id);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'File deleted successfully'
        ]);
    }
}
