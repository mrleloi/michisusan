<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentFile\StoreDocumentFileRequest;
use App\Http\Requests\DocumentFile\UpdateDocumentFileRequest;
use App\Models\DocumentFile;
use App\Services\DocumentFileService;
use App\Services\EmbedPartsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentFileController extends Controller
{
    public function __construct(private readonly DocumentFileService $documentFileService)
    {
    }

    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['integer'],
        ]);

        $items = $this->documentFileService->list($request->per_page);
        $columns = ['filename' => '文書ファイル名'];

        return view('document_files.index', [
            'items' => $items,
            'columns' => $columns,
            'perPageOptions' => EmbedPartsService::PER_PAGE_OPTIONS,
        ]);
    }

    public function create()
    {
        return view('document_files.create');
    }

    public function store(StoreDocumentFileRequest $request)
    {
        try {
            $request->validated();
            $this->documentFileService->store($request->filename, $request->file('file'));

            return redirect()->route('document_files.index')->with('success', '追加を完了しました');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withInput()->with('error', '追加に失敗しました');
        }
    }

    public function edit(DocumentFile $documentFile)
    {
        return view('document_files.edit', ['item' => $documentFile]);
    }

    public function update(UpdateDocumentFileRequest $request, DocumentFile $documentFile)
    {
        try {
            $request->validated();
            $this->documentFileService->update($documentFile, $request->filename, $request->file('file'));

            return redirect()->route('document_files.index')->with('success', '更新を完了しました');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withInput()->with('error', '更新に失敗しました');
        }
    }

    public function delete(DocumentFile $documentFile)
    {
        $this->documentFileService->delete($documentFile);

        return redirect()->route('document_files.index')->with('success', '削除を完了しました');
    }

    public function bulkDelete(Request $request)
    {
        $documentIds = $request->input('checks', []);

        if (empty($documentIds)) {
            return redirect()->route('document_files.index')->with('error', '削除する文書ファイルが選択されていません');
        }

        try {
            $this->documentFileService->bulkDelete($documentIds);

            return redirect()->route('document_files.index')->with('success', '選択した文書ファイルを削除しました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('document_files.index')->with('error', '選択した文書ファイルは削除できません');
        }
    }
}
