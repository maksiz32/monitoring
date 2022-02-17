<?php

namespace App\Http\Controllers\RemoteControls;

use App\Http\Controllers\Controller;
use App\Http\Requests\RemoteControlRequest;
use App\Models\Point;
use App\Models\RemoteControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemoteControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index']);
    }

    public function index()
    {
        return view('remote.list', ['remotes' => RemoteControl::orderBy('id')->get()]);
    }

    public function create()
    {
        return view('remote.new', ['points' => Point::all()]);
    }

    public function store(RemoteControlRequest $request)
    {
        $remote = new RemoteControl();
        $remote = $remote->fill($request->validated());

        if ($remote->save()) {
            return redirect(route('remote.index'))
                ->with('message', __('messages.remote.input.success'));
        }

        return back()->with('errors', __('messages.remote.input.fail'));
    }

    public function edit(RemoteControl $remote)
    {
        $points = Point::where('is_active', true)->get();
        $remote = RemoteControl::findOrFail($remote->id);

        return view('remote.edit', ['remote' => $remote, 'points' => $points]);
    }

    public function update(RemoteControlRequest $request, RemoteControl $remote)
    {
        $remote = $remote->fill($request->validated());

        $remoteId = $remote->save();

        if (isset($remoteId)) {
            return redirect(route('remote.index'))
                ->with('message', __('messages.remote.edit.success'));
        }

        return back()->with('errors', __('messages.remote.edit.fail'));
    }

    public function destroy(RemoteControl $remote)
    {
        try {
            $remote->delete();

            return redirect(route('remote.index'))
                ->with(['message' => __('messages.remote.delete.success')]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . PHP_EOL, $e->getTrace());

            return response()->json(['message' => __('messages.remote.delete.fail')]);
        }
    }
}
