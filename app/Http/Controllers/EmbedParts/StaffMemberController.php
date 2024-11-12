<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Models\StaffMember;
use App\Services\EmbedPartsService;
use App\Services\StaffMemberService;
use Exception;
use Illuminate\Http\Request;
use Log;

class StaffMemberController extends Controller
{
    protected $smService;

    public function __construct(StaffMemberService $smService)
    {
        $this->smService = $smService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'department_id' => ['exists:departments,id', 'nullable'],
            'visible' => ['boolean', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->smService->list($validated);
        $columns = ['name' => 'スタッフ名', 'department.name' => '部署・役職', 'visible:visible' => '表示'];
        $departmentOptions = $this->smService->getDepartmentsOfCurrentSite(false);
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable'];

        if (is_null($request->department_id) && is_null($request->keyword) && is_null($request->visible)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.staff_member.index', compact(
            'items',
            'columns',
            'perPageOptions',
            'departmentOptions',
            'visibleOptions',
            'listActions',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->smService->getDepartmentsOfCurrentSite();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $staffMemberAdditions = array_fill(0, 5, []);

        return view('embed_parts.staff_member.create', compact(
            'departments',
            'visibleOptions',
            'staffMemberAdditions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffMemberRequest $request)
    {
        //
        $staffMember = $this->smService->store($request->all());
        if ($staffMember) {
            return redirect(route('staff_member.edit', ['staff_member' => $staffMember]))->with('success', 'スタッフを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'スタッフを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffMember $staffMember)
    {
        $departments = $this->smService->getDepartmentsOfCurrentSite();
        $staffMemberAdditions = $staffMember->staffMemberAdditions()->orderBy("sort_order")->get();
        if (count($staffMemberAdditions) < 5) {
            $staffMemberAdditions = $staffMemberAdditions->concat(array_fill(0, 5 - count($staffMemberAdditions), []));
        }
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;

        return view('embed_parts.staff_member.edit', compact(
            'staffMember',
            'departments',
            'visibleOptions',
            'staffMemberAdditions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffMemberRequest $request, StaffMember $staffMember)
    {
        //
        //Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //Log::debug('staffMember validated',[$validated]);

        if (isset($validated['image_id_delete']) && $validated['image_id_delete'] == 1) {
            $request['image_id'] = null;
        }

        //Log::debug('staffMember request',[$request->all(),$staffMember]);
        try {
            $staffMember->update($request->all());
            $this->smService->syncStaffMemberAdditions($staffMember, $request->input("rows", []));
            return redirect(route('staff_member.edit', ['staff_member' => $staffMember]))->with('success', 'スタッフを変更しました');
        } catch (Exception $e) {
            Log::debug($e);
            return redirect()->back()->withInput()->with('error', 'スタッフを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffMember $staffMember)
    {
        if ($staffMember->delete()) {
            return redirect()->back()->withInput()->with('success', 'スタッフメンバーを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'スタッフメンバーを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->smService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'スタッフメンバーを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'スタッフメンバーを一括削除できませんでした');
            }
        }
    }
}
