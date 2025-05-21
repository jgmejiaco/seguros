<?php

namespace App\Http\Controllers\permisos;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\ModelHasPermissions;
use App\Models\RoleHasPermission;
use App\Models\ModelHasRoles;
use App\Http\Responsable\permisos\PermisoIndex;
use App\Http\Responsable\permisos\PermisoStore;
use App\Http\Responsable\permisos\PermisoEdit;
use App\Http\Responsable\permisos\PermisoUpdate;

class PermisosController extends Controller
{
    public function index()
    {
        return new PermisoIndex();
    }

    public function store(Request $request)
    {
        return new PermisoStore();
    }

    public function edit($idPermiso)
    {
        return new PermisoEdit($idPermiso);
    }

    public function update(Request $request, $idPermiso)
    {
        return new PermisoUpdate($idPermiso);
    }
} // FIN Class PermisosController
