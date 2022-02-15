<?php

namespace App\Http\Controllers\Printers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrinterRequest;
use App\Models\Point;
use App\Models\Printer;
use App\Models\PrinterPoint;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index']);
    }

    public function index()
    {
        return view('printer.list', ['printers' => Printer::orderBy('printers.id')->get()]);
    }

    public function store(PrinterRequest $request)
    {
        $printer = new Printer;
        $printer = $printer->fill($request->validated());
        $printer->is_spare = (int)$request->is_spare === 1;

        if ($printer->save()) {
            return redirect(route('printer.index'))
                ->with('message', __('messages.printer.input.success'));
        }

        return back()->with('errors', __('messages.printer.input.fail'));
    }

    public function create(Printer $printer)
    {
        $points = Point::where('is_active', true)->get();

        return view('printer.new', ['printer' => $printer, 'points' => $points]);
    }

    public function update(PrinterRequest $request, Printer $printer)
    {
        $printerRes = $printer->fill($request->validated());

        $printerRes->is_spare = (int)$request->is_spare === 1;

        $printerId = $printerRes->save();

        if (isset($printerId)) {
            return redirect(route('printer.index'))
                ->with('message', __('messages.printer.edit.success'));
        }

        return back()->with('errors', __('messages.printer.edit.fail'));
    }

    public function edit(Printer $printer)
    {
        $points = Point::where('is_active', true)->get();
        $printer = Printer::findOrFail($printer->id);

        return view('printer.edit', ['printer' => $printer, 'points' => $points]);
    }

    public function destroy(Printer $printer)
    {
        try {
            $printer->delete();

            return redirect(route('printer.index'))
                ->with(['message' => __('messages.printer.delete.success')]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . PHP_EOL, $e->getTrace());

            return response()->json(['message' => __('messages.printer.delete.fail')]);
        }
    }
}
