<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Question;


class FileController extends Controller
{
    static $default = 'default.png';
    static $diskName = 'FileStorage';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg'],
        'question' => ['png', 'jpg', 'jpeg', 'doc', 'docx', 'txt', 'pdf'],
        'answer' => ['png', 'jpg', 'jpeg', 'doc', 'docx', 'txt', 'pdf'],
        'game' => ['png', 'jpg', 'jpeg', 'doc', 'docx', 'txt', 'pdf'],
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
        switch($type) {
            case 'profile':
                return User::find($id)->profile_image; 
            case 'question':
                $fileNames = DB::table('question_file')
                        ->select('file_name')
                        ->where('question_id', $id)
                        ->pluck('file_name')
                        ->toArray();
                return $fileNames;
            default:
                return null;
        }
    }
    
    private static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            switch($type) {
                case 'profile':
                    Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);
                    User::find($id)->profile_image = null;
                    break;
                case 'question':
                    foreach ($existingFileName as $fileName) {
                        Storage::disk(self::$diskName)->delete($type . '/' . $fileName);
                        DB::table('question_file')->where('question_id', $id)->where('file_name', $fileName)->delete();
                    }
                    break;
            }
        }
    }

    function clear(Request $request) {
        $this->delete($request->type, $request->id);
        return response()->json(['id' => $request->id]);
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

        if ($type == 'profile') {
            $this->delete($type, $request->id);
        }

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

            case 'question':
                $question = Question::findOrFail($request->id);
                if ($question) {
                    DB::table('question_file')->insert([
                        'question_id' => $question->id,
                        'file_name' => $fileName
                    ]);
                } else {
                    $error = "unknown question";
                }
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


