<?php
namespace App\Scopes;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class QueryScope implements Scope
{
    public $count;
    public $model;
    public function __construct(){
        $this->count = 0;
    }
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(request('with')) {
            $relations = explode(";", request('with'));
            foreach($relations as $with){
                // check if this relations has only
                $with = explode(':', $with);

                if(count($with) > 1){

                    $with[1] = str_replace("[", "",$with[1]);
                    $with[1] = str_replace("]", "",$with[1]);
                    $fields = explode(',', $with[1] );
                    if(ucfirst($with[0]) == class_basename(get_class($model))){
                        $builder->addSelect($fields);
                    }

                        
                    if(method_exists($model, $with[0])){
                        $builder->with([$with[0] => function($query) use ($fields){ 
                            $query->select($fields);
                        }]);        
                    }
                }
            }
        }
        // return $builder;
    }
}