<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use getID3;

class AudioController extends Controller
{
    public function uploadAudio(Request $request)
    {
        $request->validate([
            'audioFile' => 'required|mimes:mp3', // Validate that it's an MP3 file
        ]);

        if ($request->file('audioFile')->isValid()) {
            $file = $request->file('audioFile');

            // Analyze the file using getID3
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($file->getPathname());

            $lengthInSeconds = $fileInfo['playtime_seconds'] ?? null;

            if ($lengthInSeconds !== null) {
                return gmdate("H:i:s", $lengthInSeconds);
            } else {
                return 'Unknown';
            }
        }

        return 'Invalid audio file';
    }
}
