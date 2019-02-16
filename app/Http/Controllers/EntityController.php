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
        $this->authorize('view', Entity::class);

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
// dd($create);
        return Entity::create($create);
    }

    public function update(Request $request, $id)
    {
        $entity = Entity::find($id);
        $this->authorize('update', auth()->user(), $entity);
        return $entity->update($request->all());
    }

}
