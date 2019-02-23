<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Support\Str;
use App\Models\EntityAssignment;
use App\Models\BaseRate;
use App\Models\BaseTeacherRate;

use App\Models\BasePenalty;
use App\Models\BaseTeacherPenalty;
use App\Models\TeacherRate;
use App\Models\Teacher;

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

        return $this->respond(Entity::create($create), "Entity Successfully Created.");
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

    public function assign()
    {
        // TODO: Check if teacher_provider and student provider are yours
        $created = EntityAssignment::create([
            'teacher_provider_id' => request('teacher_provider_id'),
            'student_provider_id' => request('student_provider_id')
        ]);

        if(!empty($created))
        {
            $this->createBaseTeacherRate($created);

            $this->createBaseTeacherPenalty($created);
        }

        return $this->respond($created, "Provider Successfully Assigned");
    }

    public function createBaseTeacherRate($assignment)
    {
        $rate_created = [];
        // set base rates for this student provider
        $rates = BaseRate::where("teacher_provider_id", $assignment->teacher_provider_id)->get();

        $role_id = role('teacher', $assignment->teacher_provider_id);

        foreach($rates as $rate)
        {
            $teacher_rate = BaseTeacherRate::create(
                array_merge($rate->toArray(), [
                    'student_provider_id' => $assignment->student_provider_id
                ])
            );
            // check all existing teacher for this teacher_provider and create teacher rate for them
            $teachers = Teacher::where('entity_id', $assignment->teacher_provider_id)
                ->where('role_id', $role_id)
                ->get();
                
            foreach($teachers as $teacher)
            {
                try
                {
                    $rate_created[] = TeacherRate::create(
                        array_merge($teacher_rate->toArray(), [
                            'teacher_id' => $teacher->id
                        ])
                    );    
                }
                catch(\Exception $ex)
                {
                    continue;
                }
            }
        }

        return $rate_created;
    }


    public function createBaseTeacherPenalty($assignment)
    {
        // check if there are BaseTeacherPenalty for this given 
        $teacher_penalties = BaseTeacherPenalty::where('teacher_provider_id', $assignment->teacher_provider_id)
            ->where('student_provider_id', $assignment->student_provider_id)
            ->get();

        if($teacher_penalties->isEmpty())
        {
            $penalties_created = [];
            // set base penalties for this student provider
            // in the future we will provide a mechanism for teacher providers to change base teacher penalties
            $penalties = BasePenalty::where("teacher_provider_id", $assignment->teacher_provider_id)
            ->get();

            foreach($penalties as $penalty)
            {
                $penalties_created = BaseTeacherPenalty::create(
                    array_merge($penalty->toArray(), [
                        'student_provider_id' => $assignment->student_provider_id
                    ])
                );
            }    

            return $penalties_created;
        }

        return false;
    }

}
