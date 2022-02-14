<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\Point;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index']);
    }

    public function create()
    {
        $points = Point::where('is_active', true)->get();

        return view('contract.new', ['points' => $points]);
    }

    public function edit(Contract $contract)
    {
        $contract = Contract::findOrFail($contract->id);
        $points = Point::all();

        return view('contract.edit', ['contract' => $contract, 'points' => $points]);
    }

    public function store(ContractRequest $request)
    {
        $contract = Contract::create($request->validated());

        if ($contract->save()) {
            return redirect(url('/contract'))
                ->with('message', __('messages.contract.input.success'));
        }

        return back()->with('errors', __('messages.contract.input.fail'));
    }

    public function update(ContractRequest $request, Contract $contract)
    {
        $contract = $contract->fill($request->validated());

        if ($contract->save()) {
            return redirect(url('/contract'))
                ->with('message', __('messages.contract.edit.success'));
        }

        return back()->with('errors', __('messages.contract.edit.fail'));
    }

    public function index()
    {
        return view('contract.list', ['contracts' => Contract::orderBy('id')->get()]);
    }
}
