<?php

namespace App\Http\Controllers\Devices;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Point;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->only(['destroy']);
    }

    public function index()
    {
        return view('device.list', ['devices' => Device::orderBy('id')->get()]);
    }

    public function create()
    {
        return view('device.new', ['points' => Point::all()]);
    }

    public function store()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }
}
