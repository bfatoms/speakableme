<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntityPackage;
use App\Models\BasePackage;

class EntityPackageController extends Controller
{
    public function store()
    {
        $package = BasePackage::find(request('base_package_id'));
    
        $add = request('additional_price') ?? 0;
        
        $total = 0;
        
        $data = [
            "entity_id" => eid(),
            "class_type_id" => $package->class_type_id,
            "base_price" => $package->base_price,
            "name" => request('name'),
            "additional" => $add,
            "total" => (floatval($add) + floatval($package->base_price)),
            "number_of_classes" => $package->number_of_classes,
            "duration_in_days" => $package->duration_in_days
        ];

        return $this->respond(EntityPackage::create($data), "Package successfully created");
    }

    public function update($id)
    {
        $package = EntityPackage::find($id);

        $add = request('additional_price') ?? 0;
        
        $data = [
            "entity_id" => eid(),
            "class_type_id" => $package->class_type_id,
            "base_price" => $package->base_price,
            "name" => request('name') ?? $package->name,
            "additional" => $add,
            "total" => (floatval($add) + floatval($package->base_price)),
            "number_of_classes" => $package->number_of_classes,
            "duration_in_days" => $package->duration_in_days
        ];

        $package->update($data);

        return $this->respond($package->refresh(), "Package successfully created");
    }


    public function index()
    {
        return $this->respond(
            EntityPackage::where('entity_id', eid())
            ->get(),
            "All package Found!"
        );
    }

    public function show($id)
    {
        // dd(EntityPackage::where('id', $id)->first());

        return $this->respond(
            EntityPackage::where('entity_id', eid())
                ->where('id', $id)
                ->first(),
            "Package Found!"
        );
    }

    public function destroy($id)
    {
        $package = EntityPackage::find($id);
        $package->delete();
        return $this->respond($package, "Package Successfully Deleted");
    }
}