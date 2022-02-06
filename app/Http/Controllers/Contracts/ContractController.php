<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\Point;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function new(Contract $contract)
    {
        return view('contract.new', ['contract' => $contract]);
    }

    public function edit($id)
    {
        $contract = Contract::find($id);

        return view('contract.new', ['contract' => $contract]);
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

            $point = Point::where('contract_id', $contract->id)->first();

            return redirect(url('/'))
                ->with(['message' => __('messages.contract.store.success')]);
        }

        return back()->with(['errors' => __('messages.contract.store.fail')]);
    }

//    public function input(ContractRequest $request)
//    {
//        $contract = Contract::create($request->validated());
//        $contract_id = $this->store($contract);
//
//        if (isset($contract_id)) {
//
//            return redirect(url('/'))
//                ->with(['message' => __('messages.contract.input.success')]);
//        }
//
//        return back()->with(['errors' => __('messages.contract.input.fail')]);
//    }

}
