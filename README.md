# speakableme


## FOR DEVELOPERS
#ENTITIES
- Every Entity Created has a default email, identified in entities table, this was used to setup the first user "superadmin of that entity|organization|school", if you changed the superadmin email in users table, you need to change the default_email in entities as well.
- Every Entity Created, creates a role and permissions and user, please check App\Observers\EntityObserver.php for codes

#LOGGING EVENTS
- use trait App\Traits\EventLoggable;
- after you can use $model->logs()->create(); etc...
