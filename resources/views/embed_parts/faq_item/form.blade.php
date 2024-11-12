@push('styles')
    @vite('resources/css/table.css')
@endpush
<div class="border">
    <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
    </div>
    <div class="p-4">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>カテゴリー<span class="text-red-500">※</span></th>
                    <td>
                        <category-selector size="small" name="faq_category_id" :options="@js($faqCategories)" option-label="name"
                            option-value="id" :value="@js(intval( old('category_id', $faqItem->faq_category_id ?? ''), 10))"
                            :multiple="false"
                            class="w-full" dialog_component="FaqItemCategorySelector" placeholder="選択してください">
                        </category-selector>
                        <x-form-error for="faq_category_id"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>質問内容<span class="text-red-500">※</span></th>
                    <td>
                        <ck-editor name="question" class="w-full"
                            value="{{ old('question', $faqItem->question ?? '') }}">
                        </ck-editor>
                        <x-form-error for="question"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>回答内容<span class="text-red-500">※</span></th>
                    <td>
                        <ck-editor name="answer" class="w-full"
                            value="{{ old('answer', $faqItem->answer ?? '') }}">
                        </ck-editor>
                        <x-form-error for="answer"></x-form-error>
                    </td>
                </tr>
                <tr>
                    <th>表示・非表示</th>
                    <td>
                        <div class="flex flex-wrap gap-x-24">
                            <pv-radio-button name="visible" :options='@json($visibleOptions)'
                                value="{{ old('visible', $galleryCategory->visible ?? '1') }}"></pv-radio-button>
                        </div>
                        <x-form-error for="visible"></x-form-error>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
