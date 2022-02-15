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
        $this->middleware('is_admin')->except(['list']);
    }

    public function new(Contract $contract)
    {
        $points = Point::where('is_active', true)->get();

        return view('contract.new', ['contract' => $contract, 'points' => $points]);
    }

    public function edit(Contract $contract)
    {
        $contract = Contract::with(['point'])->find($contract->id);
        $points = Point::all();

        return view('contract.new', ['contract' => $contract, 'points' => $points]);
    }

    public function store(Contract $contract): ?int
    {
        if ($contract->save()) {
            return $contract->id;
        }

        return null;
    }

    public function save(ContractRequest $request, Contract $contract)
    {
        $contractRes = $contract->fill($request->validated());
        $contract_id = $this->store($contractRes);

        if (isset($contract_id)) {
            return redirect(url('/point'))
                ->with(['message' => __('messages.contract.store.success')]);
        }

        return back()->with(['errors' => __('messages.contract.store.fail')]);
    }

    public function list()
    {
        return view('contract.list', ['contracts' => Contract::with(['point'])->get()]);
    }
}
