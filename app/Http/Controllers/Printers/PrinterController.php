<?php

namespace App\Http\Controllers\Printers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrinterRequest;
use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function new(Printer $printer)
    {
        return view('printer.new', ['printer' => $printer]);
    }

    public function edit($id)
    {
        $printer = Printer::find($id);

        return view('printer.new', ['printer' => $printer]);
    }

    public function store(Printer $printer): ?int
    {
        if ($printer->save()) {
            return $printer->id;
        }

        return null;
    }

    public function save(PrinterRequest $request, Printer $printer)
    {
        $printerRes = $printer->fill($request->validated());
        $printer_id = $this->store($printerRes);

        if (isset($printer_id)) {
            return redirect(url('/'))
                ->with(['message' => __('messages.contract.store.success')]);
        }

        return back()->with(['errors' => __('messages.contract.store.fail')]);
    }

    public function list()
    {
        return view('printer.list', ['printers' => Printer::all()]);
    }
}
