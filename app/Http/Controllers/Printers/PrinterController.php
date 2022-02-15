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
        $this->middleware('is_admin')->except(['list']);
    }

    public function index()
    {
        return view('printer.list', ['printers' => Printer::with(['points'])->get()]);
    }

    public function store(PrinterRequest $request)
    {
        $printer = Printer::create($request->validated());
        $printerId = $printer->save();

        // Добавляю связь в сводную таблицу
        if (isset($request->pointId)) {
            $printer->points()->attach((int)$request->pointId);
        }

        if (isset($printerId)) {
            return redirect(route('printer.index'))
                ->with('message', __('messages.printer.store.success'));
        }

        return back()->with('errors', __('messages.printer.store.fail'));
    }

    public function create(Printer $printer)
    {
        $points = Point::where('is_active', true)->get();

        return view('printer.new', ['printer' => $printer, 'points' => $points]);
    }

    public function update(Request $request, Printer $printer)
    {
        $validated = $request->validate([
                                            'id' => 'required|nullable|integer|exists:printers,id',
                                            'name' => ['required', 'string', 'max:255'],
                                            'description' => 'nullable|string',
                                            'pointId' => 'sometimes|nullable|integer|exists:points,id',
                                        ]);
        $printerRes = $printer->fill($validated);
        $printerId = $printerRes->save();

        if (isset($request->pointId)) {
            $printer->points()->detach();
            $printer->points()->attach([
                                           'printer_id' => $printerId,
                                           'point_id' => (int)$request->pointId,
                                       ]);
        } else {
            $printer->points()->detach();
        }

        if (isset($printerId)) {

            return redirect(route('printer.index'))
                ->with('message', __('messages.printer.store.success'));
        }

        return back()->with('errors', __('messages.printer.store.fail'));
    }

    public function edit(Printer $printer)
    {
        $points = Point::where('is_active', true)->get();
        $printer = Printer::find($printer->id);

        return view('printer.edit', ['printer' => $printer, 'points' => $points]);
    }
}
