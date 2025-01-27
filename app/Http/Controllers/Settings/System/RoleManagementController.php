<?php

namespace App\Http\Controllers\Settings\System;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminBaseController;
use App\Services\Settings\Systems\RoleManagementService;
use App\Http\Requests\Settings\Systems\CreateRoleRequest;
use App\Http\Requests\Settings\Systems\UpdateRoleRequest;
use App\Http\Resources\Settings\Systems\SubmitRoleResource;
use App\Http\Resources\Settings\Systems\RoleManagementListResource;

class RoleManagementController extends AdminBaseController
{
    public function __construct(RoleManagementService $roleManagementService)
    {
        $this->roleManagementService = $roleManagementService;
    }

    public function getRoleList(Request $request)
    {
        try {
            $data = $this->roleManagementService->getData($request);

            $result = new RoleManagementListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createRolePage(Request $request)
    {
        return Inertia::render($this->source . 'settings/systems/role/create', [
            "title" => 'TrustHR | Setting System Authentication',
            "additional" => [
                'permission_list' => $this->roleManagementService->getPermissionList()
            ]
        ]);
    }

    public function editRolePage($id, Request $request)
    {
        return Inertia::render($this->source . 'settings/systems/role/edit', [
            "title" => 'TrustHR | Setting System Authentication',
            "additional" => [
                'permission_list' => $this->roleManagementService->getPermissionList(),
                'role' => $this->roleManagementService->findRoleById($id),
                'role_has_permissions' => $this->roleManagementService->getRoleHasPermissions($id)
            ]
        ]);
    }

    public function storeNewRole(CreateRoleRequest $request)
    {
        try {
            $data = $this->roleManagementService->storeData($request);

            $result = new SubmitRoleResource($data, 'Success Create New Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function updateRole($id, UpdateRoleRequest $request)
    {
        try {
            $data = $this->roleManagementService->updateData($id, $request);

            $result = new SubmitRoleResource($data, 'Success Update Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteRole($id)
    {
        try {
            $data = $this->roleManagementService->deleteData($id);

            $result = new SubmitRoleResource($data, 'Success Delete Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
