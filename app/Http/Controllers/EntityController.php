<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Support\Str;

class EntityController extends Controller
{
    public function index()
    {
        $this->authorize('browse', Entity::class);
        return $this->respond(Entity::where('managed_by_id', auth()->user()->entity_id)->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Entity::class);
        $entity_type_id = request('entity_type_id') ??
            EntityType::where('name', 'Corporate')->first()->id;
        
        $create = array_merge($request->all(),[
            'id' => (string) Str::uuid(),
            'entity_type_id' => $entity_type_id,
        ]);

        return $this->respond(Entity::create($create));
    }

    public function show($id)
    {
        $entity = Entity::find($id);
        $this->authorize('view', $entity);
        return $this->respond($entity);
    }

    public function update(Request $request, $id)
    {
        $entity = Entity::find($id);
        $this->authorize('update', $entity);
        $entity->update($request->all());
        return $this->respond($entity->refresh());
    }

}
