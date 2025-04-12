<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    public function ckeditorImageUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $foto = $request->file('upload');
            $request->validate([
                'upload' => 'mimes:jpg,jpeg,png|max:2048'
            ]);

            $fotoName = time() . '_' . $foto->getClientOriginalName();

            $fotoPath = $foto->move('images/ckeditorimage', $fotoName);

            $data['foto'] = 'images/ckeditorimage/' . $fotoName;

            $url = asset($data['foto']);

            $response = [
                'uploaded' => true,
                'url' => $url,
                'message' => 'File uploaded successfully.'
            ];
        } else {
            $response = [
                'uploaded' => false,
                'message' => 'No file uploaded.'
            ];
        }

        return response()->json($response);
    }


    public function ckeditorImageDelete(Request $request)
    {
        $filename = $request->input('filename');

        if ($filename) {
            $imagePath = 'images/ckeditorimage/' . $filename;

            if (file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Unable to delete file']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'File not found']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Filename is missing']);
        }
    }
}
