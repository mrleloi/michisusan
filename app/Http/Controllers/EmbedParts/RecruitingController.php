<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecruitingRequest;
use App\Http\Requests\UpdateRecruitingRequest;
use App\Models\Recruiting;
use App\Services\EmbedPartsService;
use App\Services\RecruitingService;
use Illuminate\Http\Request;
use Log;

class RecruitingController extends Controller
{
    protected $recruitingService;

    public function __construct(RecruitingService $recruitingService)
    {
        $this->recruitingService = $recruitingService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer'],
            'category_id' => ['integer'],
            'visible' => ['integer'],
            'keyword' => [],
        ]);

        $items = $this->recruitingService->list($validated);
        $columns = ['title' => 'タイトル', 'visible:visible' => '表示'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable', 'copy'];

        if (is_null($request->keyword)) {
            array_push($listActions, 'sortable');
        }

        return view('embed_parts.recruiting.index', compact(
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
        //
        $recruitingCategories = $this->recruitingService->getCategoryOfCurrentSite();
        $employmentStatusTypes = $this->recruitingService->getEmploymentStatusTypes();
        $salaryTypes = $this->recruitingService->getSalaryTypes();
        $mvTextTypes = $this->recruitingService->getMVTextTypes();
        $buttonLinkTypes = $this->recruitingService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->recruitingService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $recruitingFields = array_fill(0, 5, []);

        return view('embed_parts.recruiting.create', compact(
            'recruitingCategories',
            'employmentStatusTypes',
            'salaryTypes',
            'mvTextTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            //'recruiting',
            'recruitingFields',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecruitingRequest $request)
    {
        $req = $request->all();

        if (isset($req['recruiting_category_id']) && !$req['recruiting_category_id']) {
            $req['recruiting_category_id'] = null; // 未選択で0が渡ってきてしまうので
        }

        $recruiting = $this->recruitingService->store($req);

        if ($recruiting) {
            return redirect(route('recruiting.edit', ['recruiting' => $recruiting]))->with('success', '求人情報をを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報を追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recruiting $recruiting)
    {
        $recruitingCategories = $this->recruitingService->getCategoryOfCurrentSite();
        $employmentStatusTypes = $this->recruitingService->getEmploymentStatusTypes();
        $salaryTypes = $this->recruitingService->getSalaryTypes();
        $mvTextTypes = $this->recruitingService->getMVTextTypes();
        $buttonLinkTypes = $this->recruitingService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->recruitingService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $recruitingFields = $recruiting->recruitingAdditions()->orderBy("sort_order")->get();
        if (count($recruitingFields) < 5) {
            $recruitingFields = $recruitingFields->concat(array_fill(0, 5 - count($recruitingFields), []));
        }

        return view('embed_parts.recruiting.edit', compact(
            'recruitingCategories',
            'employmentStatusTypes',
            'salaryTypes',
            'mvTextTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            'recruiting',
            'recruitingFields',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecruitingRequest $request, Recruiting $recruiting)
    {
        //
        //\Log::debug('update',[$request->all()]);
        $validated = $request->validated();
        //\Log::debug('recruiting validated',[$validated]);

        for ($j = 1; $j <= 3; $j++) {
            if (isset($validated['image_id' . $j . '_delete']) && $validated['image_id' . $j . '_delete'] == 1) {
                $request['image_id' . $j] = null;
            }
        }

        //Log::debug('recruiting request',[$request->all(),$recruiting]);
        if ($recruiting->update($request->all())) {
            $this->recruitingService->syncRecruitingAdditions($recruiting, $request->input("rows", []));
            return redirect(route('recruiting.edit', ['recruiting' => $recruiting]))->with('success', '求人情報を変更しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報を変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recruiting $recruiting)
    {
        if ($recruiting->delete()) {
            return redirect()->back()->withInput()->with('success', '求人情報を削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', '求人情報を削除できませんでした');
        }
    }

    public function copy(Recruiting $recruiting)
    {
        $recruitingCategories = $this->recruitingService->getCategoryOfCurrentSite();
        $employmentStatusTypes = $this->recruitingService->getEmploymentStatusTypes();
        $salaryTypes = $this->recruitingService->getSalaryTypes();
        $mvTextTypes = $this->recruitingService->getMVTextTypes();
        $buttonLinkTypes = $this->recruitingService->getButtonLinkTypes();
        $buttonLinkOpenTypes = $this->recruitingService->getButtonLinkOpenTypes();
        $visibleOptions = EmbedPartsService::VISIBLE_OPTIONS;
        $recruitingFields = $recruiting->recruitingAdditions()->orderBy("sort_order")->get();
        if (count($recruitingFields) < 5) {
            $recruitingFields = $recruitingFields->concat(array_fill(0, 5 - count($recruitingFields), []));
        }
        $recruiting = $recruiting->replicate();

        return view('embed_parts.recruiting.create', compact(
            'recruitingCategories',
            'employmentStatusTypes',
            'salaryTypes',
            'mvTextTypes',
            'buttonLinkTypes',
            'buttonLinkOpenTypes',
            'visibleOptions',
            'recruiting',
            'recruitingFields',
        ));
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->recruitingService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', '求人情報を一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', '求人情報を一括削除できませんでした');
            }
        }
    }

    public function registCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['max:250'],
        ]);

        return response()->json($this->recruitingService->registerCategory($validated));
    }
}
