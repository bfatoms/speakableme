<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasePackage;

class BasePackageController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', BasePackage::class);
        return $this->respond(
            BasePackage::create($request->all()),
            "Base Packages Successfully Created");
    }

    public function update(Request $request, $id)
    {
        $data = BasePackage::find($id);
        $this->authorize('update', $data);
        $data->update($request->all());
        return $this->respond($data->refresh(),"Base Pacakage Successfully Updated");
    }

    public function show($id)
    {
        $entity = BasePackage::find($id);
        $this->authorize('view', $entity);
        return $this->respond($entity);
    }

    public function index()
    {
        $this->authorize('browse', BasePackage::class);

        return $this->respond(BasePackage::where('entity_id', auth()->user()->entity_id)->get());
    }

    public function providerIndex()
    {
        $this->authorize('browse', BasePackage::class);

        return $this->respond(BasePackage::where('student_provider_id', auth()->user()->entity_id)->get());
    }

    
}
