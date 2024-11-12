<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use App\Services\EmbedPartsService;
use Exception;
use Illuminate\Http\Request;
use Log;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'department_id' => ['integer', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->departmentService->list($validated);
        $columns = ['name' => '部署・役職'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable', 'sortable'];

        return view('embed_parts.department.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'listActions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('embed_parts.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->departmentService->store($request->validated());
        if ($department) {
            return redirect(route('department.edit', ['department' => $department]))->with('success', '部署・組織を追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', '部署・組織を追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('embed_parts.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        try {
            $department->update($request->all());
            return redirect(route('department.edit', ['department' => $department]))->with('success', '部署・組織を変更しました');
        } catch (Exception $e) {
            Log::debug($e);
            return redirect()->back()->withInput()->with('error', '部署・組織を変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->delete()) {
            return redirect()->back()->withInput()->with('success', '部署・役職を削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', '部署・役職を削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->departmentService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '部署・役職を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', '部署・役職を一括削除できませんでした');
            }
        }
    }
}
