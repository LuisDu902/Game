<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class FileController extends Controller
{
    static $default = 'default.png';
    static $diskName = 'FileStorage';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg'],
        'question' => ['png', 'jpg', 'jpeg'],
        'answer' => ['png', 'jpg', 'jpeg'],
        'game' => ['png', 'jpg', 'jpeg'],
    ];

    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }
    
    private static function getDefaultExtension(String $type) {
        return reset(self::$systemTypes[$type]);
    }

    private static function isValidExtension(String $type, String $extension) {
        $allowedExtensions = self::$systemTypes[$type];
        return in_array(strtolower($extension), $allowedExtensions);
    }

    private static function defaultAsset(String $type) {
        return asset($type . '/' . self::$default);
    }
    
    private static function getFileName(String $type, int $id, String $extension = null) {

        $fileName = null;
        switch($type) {
            case 'profile':
                $fileName = User::find($id)->profile_image; 
                break;
            case 'post':
                break;
            default:
                return null;
        }

        return $fileName;
    }
    
    private static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);

            switch($type) {
                case 'profile':
                    User::find($id)->profile_image = null;
                    break;
                case 'post':
                    break;
            }
        }
    }

    function upload(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'File not found'], 400);
        }
        if (!$this->isValidType($request->type)) {
            return response()->json(['error' => 'Unsupported upload type'], 400);
        }
        $file = $request->file('file');
        $type = $request->type;
        $extension = $file->extension();
        if (!$this->isValidExtension($type, $extension)) {
            return response()->json(['error' => 'Unsupported upload extension'], 400);
        }
        $this->delete($type, $request->id);
        $fileName = $file->hashName();
        $error = null;
        switch($request->type) {
            case 'profile':
                $user = User::findOrFail($request->id);
                if ($user) {
                    $user->profile_image = $fileName;
                    $user->save();
                } else {
                    $error = "unknown user";
                }
                break;

            case 'post':
                break;

            default:
                return response()->json(['error' => 'Unsupported upload object'], 400);
        }

        if ($error) {
            return response()->json(['error' => $error], 400);
        }

        $file->storeAs($type, $fileName, self::$diskName);
        return response()->json(['success' => 'Upload completed!'], 200);
    }

    static function get(String $type, int $userId) {
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }
        return self::defaultAsset($type);
    }
    
    
}


