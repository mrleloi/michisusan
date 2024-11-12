<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Services\TemplatesService;

class TemplateController extends Controller
{
    protected $templatesService;

    public function __construct(
        TemplatesService $templatesService
    ) {
        $this->templatesService = $templatesService;
    }

    public function index(Request $request) {
        $par_page_choices = [
            ['label' => '10件表示', 'value' => 10],
            ['label' => '20件表示', 'value' => 20],
            ['label' => '50件表示', 'value' => 50],
            ['label' => '100件表示', 'value' => 100],
            ['label' => '200件表示', 'value' => 200]
        ];
        $limit = $request->get('per_page') ?? $par_page_choices[0]['value'];
        $templates = $this->templatesService->getTemplates($limit);
        $columns = ['id' => 'テンプレート名'];

        return view('templates.index', [
            'items' => $templates,
            'columns' => $columns,
            'actions' => ['edit', 'delete', 'bulk_delete'],
            'query' => ['par_page_choices' => $par_page_choices],
            'limit' => $limit
        ]);
    }
    
    public function edit(Request $request, string $id) {
        $this->templatesService->update($id, [
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        return Redirect::route('templates.index');
    }
    
    public function destroy(Request $request, string $id) {
        $template = $this->templatesService->findById($id);
        $this->templatesService->destroy($id);
        return Redirect::route('templates.index');
    }
}
