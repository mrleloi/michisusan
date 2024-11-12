<?php

namespace App\Http\Controllers\EmbedParts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryFormRequest;
use App\Http\Requests\UpdateInquiryFormRequest;
use App\Models\InquiryForm;
use App\Services\EmbedPartsService;
use App\Services\InquiryFormService;
use Exception;
use Illuminate\Http\Request;
use Log;

class InquiryFormController extends Controller
{
    protected $ifService;

    public function __construct(InquiryFormService $ifService)
    {
        $this->ifService = $ifService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['integer', 'nullable'],
            'category_id' => ['exists:faq_categories,id', 'nullable'],
            'visible' => ['boolean', 'nullable'],
            'keyword' => [],
        ]);

        $items = $this->ifService->list($validated);
        $columns = ['form_name' => 'フォーム名'];
        $perPageOptions = EmbedPartsService::PER_PAGE_OPTIONS;
        $listActions = ['delete', 'edit', 'selectable', 'history'];

        return view('embed_parts.inquiry_form.index', compact(
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
        $remarkTypeOptions = $this->ifService->getRemarkTypeOptions();
        $fieldTypeOptions = $this->ifService->getFieldTypeOptions();
        $inquiryFormFields = array_fill(0, 1, []);

        return view('embed_parts.inquiry_form.create', compact(
            'remarkTypeOptions',
            'fieldTypeOptions',
            'inquiryFormFields',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInquiryFormRequest $request)
    {
        $inquiryForm = $this->ifService->store($request->all());

        if ($inquiryForm) {
            $this->ifService->syncInquiryFormAdditions($inquiryForm, $request->input("rows", []));
            return redirect(route('inquiry_form.edit', ['inquiry_form' => $inquiryForm]))->with('success', 'お問い合わせフォームを追加しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'お問い合わせフォームを追加できませんでした');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InquiryForm $inquiryForm)
    {
        $remarkTypeOptions = $this->ifService->getRemarkTypeOptions();
        $fieldTypeOptions = $this->ifService->getFieldTypeOptions();
        $inquiryFormFields = $inquiryForm->inquiryFormAdditions()->orderBy("sort_order")->get();
        if (count($inquiryFormFields) < 1) {
            $inquiryFormFields = $inquiryFormFields->concat(array_fill(0, 1 - count($inquiryFormFields), []));
        }

        return view('embed_parts.inquiry_form.edit', compact(
            'inquiryForm',
            'remarkTypeOptions',
            'fieldTypeOptions',
            'inquiryFormFields',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function history(InquiryForm $inquiryForm)
    {
        return redirect()->route('inquiry_log.index', ['inquiry_form_id' => $inquiryForm->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInquiryFormRequest $request, InquiryForm $inquiryForm)
    {
        $validated = $request->validated();

        try {
            $inquiryForm->update($validated);
            $this->ifService->syncInquiryFormAdditions($inquiryForm, $request->input("rows", []));
            return redirect(route('inquiry_form.edit', ['inquiry_form' => $inquiryForm]))->with('success', 'お問い合わせフォームを変更しました');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'お問い合わせフォームを変更できませんでした');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InquiryForm $inquiryForm)
    {
        if ($inquiryForm->delete()) {
            return redirect()->back()->withInput()->with('success', 'お問い合わせフォームを削除しました');
        } else {
            return redirect()->back()->withInput()->with('error', 'お問い合わせフォームを削除できませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'checks' => ['array'],
            'checks.*' => ['integer'],
        ]);

        if (array_key_exists('checks', $validated)) {
            if ($this->ifService->deleteAll($validated['checks'])) {
                return redirect()->back()->withInput()->with('success', 'お問い合わせフォームを一括削除しました');
            } else {
                return redirect()->back()->withInput()->with('error', 'お問い合わせフォームを一括削除できませんでした');
            }
        }
    }   //
}
