# speakableme


## FOR DEVELOPERS
#ENTITIES
- Every Entity Created has a default email, identified in entities table, this was used to setup the first user "superadmin of that entity|organization|school", if you changed the superadmin email in users table, you need to change the default_email in entities as well.
- Every Entity Created, creates a role and permissions and user, please check App\Observers\EntityObserver.php for codes

#LOGGING EVENTS
- use trait App\Traits\EventLoggable;
- after you can use $model->logs()->create(); etc...


## Helpers
- use this helpers below to check for the ability of the Entity, for logged in user
userEntityCan('manage_clients')
userEntityCan('manage_students')
userEntityCan('manage_teachers')

- use this helpers below to check for permissions for the logged in user
can('do-all')

- use to check ownership of entity return ($user->entity_id === $entity->managed_by_id)
owner($user, $entity)