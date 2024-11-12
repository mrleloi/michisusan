<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DepartmentService;
use App\Services\StaffMemberService;
use Illuminate\Http\Request;

class StaffMemberController extends Controller
{
    protected $smService;
    protected $departmentService;

    public function __construct(StaffMemberService $smService, DepartmentService $departmentService)
    {
        $this->smService = $smService;
        $this->departmentService = $departmentService;
    }

    public function getDepartments()
    {
        try {
            return responseOkAPI($this->departmentService->getAll());
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function getItemsByDepartment(Request $request)
    {
        $request->validate([
            'categorized' => ['boolean'],
            'departmentIds' => ['nullable', 'array'],
            'departmentIds.*' => ['nullable', 'integer'],
            'allDepartments' => ['nullable', 'boolean'],
            'itemCount' => ['nullable', 'integer'],
            'siteId' => ['nullable', 'integer'],
        ]);

        try {
            $departmentIds = $request->departmentIds ? : [];

            return responseOkAPI($this->smService->getItems(
                $request->categorized,
                $request->allDepartments ? null :  $departmentIds,
                $request->itemCount,
                $request->siteId,
            ));
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
