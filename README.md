# Nord62
Basic php Laravel training example.  

Nord62 (YellowKnife) Canada/@62.4747917,-114.5490756

This is a training project, not intended to be a full application. Some functionalities will be duplicated to provide a comparison between multiple programming techniques and API calls to different services.

Login behaviour:

The Auth model uses for default email as a login identifier. Most of the users have few emails accounts, this situation increase the risk to allow access to the wrong user.
The hacker work is reduced by 50%, once (s)he has the first part of the access granted, "The email account". 
Having multiple "Usernames" for different applications WAS SAFER, but were more work for the "Marketing" guys. (THANK YOU! )

### Access Control List

This Laravel instance use "spatie/laravel-permission" implementation, permission and roles.
https://github.com/spatie/laravel-permission

The initial setup is based on the "installation isntructions" provided by the maintainer.

Description field was added to the permissions and roles tables.

The "CRUD" (Create-Read-Update-Delete) implementation is one of the training excercises.

### Users & Profiles

Assign a profile to a User. The profile will contain most of the specific information of the user. 
The profile record needs to be created at the moment of the user creation. In this example the Users table will control the basic access to the application, and the profile will grant access to specific routines and resources provided by the application.
First, we need to create the basic CRUD infrastructure to maintain our users and profile tables

```php
public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $permissions = Permission::get()->pluck('name', 'name');

        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role', 'permissions'));
    }
```

### Record access control

Add the fields to control the access by record to all the tables, additional indexes are needed.

| field | description
| ---: | ---:
| owner_id | User id who created the record

```
    // Filtered by owner_id
    $users = User::where('owner_id',auth()->id())->orderby('id', 'desc')->get();

```

#### Validate modifications in:

- [ ] Migration
- [ ] Seeders
- [ ] Model

#### Implementation

    All new tables should have the suggested fields:

| field | description
| ---: | ---:
| owner_id | User id who created the record
| updated_id | User id who created the record


#### Options

More complex record access control could be implemented, by group_id (many groups), role_id (many roles), user_id (many_users)
and with Unix file permissions structure:  Owner | Group| Other with permissions: Read-Write-Execute => Create-Edit-Delete-View
or even ownership transfer.



### Tasks

- [X] Basic Laravel Auth
- [X] Spatie/Permissions
- [X] Users / Profile Link


