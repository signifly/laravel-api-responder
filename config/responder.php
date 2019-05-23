<?php

return [

    /*
     * The namespace to use when resolving resources.
     */
    'namespace' => 'App\\Http\\Resources',

    /*
     * Force the usage of resources.
     *
     * It will throw a ResourceNotFoundException
     * if it does not resolve a resource.
     */
    'force_resources' => false,

    /*
     * Indicates if the resources uses a naming convention with a type suffix.
     *
     * If it is set to true it will try to resolve `UserResource`.
     */
    'use_type_suffix' => false,

];
