<?php


/**
 * This function checks is var is set and not empty or null otherwise return null.
 * @param any $var
 */
function ifEmptyReturnNull($var)
{
    if (empty($var) || is_null($var) || !isset($var)) {
        return null;
    }

    return $var;
}


function getPolicy($user = null) {
    if(!$user){
        $user = \Illuminate\Support\Facades\Auth::user();
    }
    $permissions = [
        'edit_provider_profiles' => false,
        'edit_participants_profiles' => false,
        'edit_representatives_profiles' => false,
        'approving_claims' => false,
        'export_import_documents' => false,
        'add_edit_plans' => false
    ];
    foreach ($user->permissions()->get() as $p){
        $permissions[$p->name] = true;
    }
    return [
        'is_supper_admin' => $user->hasRole('admin'),
        'permissions' => $permissions
    ];


}
