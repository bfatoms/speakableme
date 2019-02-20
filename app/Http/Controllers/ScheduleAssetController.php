<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleAsset;
use Illuminate\Support\Facades\Storage;

class ScheduleAssetController extends Controller
{
    public function store($id = null)
    {
        $filepath = auth()->user()->id.'/books';

        $path = request()->file('book')->store($filepath, 'public');

        $create = [
            'schedule_id' => request('schedule_id') ?? $id,
            'user_id' => auth()->user()->id,
            'path' => $path,
            'url' => config('app.url').Storage::url($path),
            'lesson_unit' => request('lesson_unit'),
            'page_number' => request('page_number'),
            'message' => request('message'),
        ];

        $data = ScheduleAsset::create($create);

        return $this->respond($data, "Successfully Uploaded");
    }
    
}