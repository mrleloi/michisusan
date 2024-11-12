<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">新規追加</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center">
            <span class="text-[#FF0000] text-[12px] font-semibold">
                ※
            </span>
            <span>
               は入力必須項目です。
            </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken">
            <div class="border border-[#DFE7EF] px-[25px] py-[21px] rounded-b font-[Inter]">
                <h1 class="text-[22px] font-semibold leading-[33px] mb-2">基本設定</h1>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">新着情報名</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[24px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.name" name="name" maxLength="255" />
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.name?.length">{{props.errormessage?.name?.[0]}}</span>
                        <div class="pt-3 flex items-center justify-between">
                            <div>
                                <Checkbox name="with_seo_title" binary v-model="settingForm.with_seo_title" />
                                <label class="ml-2" for="with_seo_title">SEO付与タイトルに追加する</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ディレクトリ名</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[36px] pb-[12px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.directory" name="directory" maxLength="30" />
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.directory?.length">{{props.errormessage?.directory?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ページタイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[36px] pb-[12px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.page_title" name="page_title" maxLength="50" placeholder="titleタグに使用されます"/>
                        <div class="pt-3 flex items-center justify-end">
                            <span class="text-right font-semibold">{{settingForm.page_title.length}}文字/30文字</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">description</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[28px] pb-[12px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.description" name="description" maxLength="120" placeholder="meta discription及び関連記事リンクの説明文に使用されます"/>
                        <div class="pt-3 flex justify-end">
                            <span class="text-right font-semibold">{{settingForm.description.length}}文字/120文字</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-1">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">h1テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[28px] pb-[12px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.h1_text" name="h1_text" maxLength="50" placeholder="ページ上部にあるh1タグテキストに使用されます"/>
                        <div class="pt-3 flex justify-end">
                            <span class="text-right font-semibold">{{settingForm.h1_text.length}}文字/20文字</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">keywords</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="settingForm.keywords" name="keywords" maxLength="120" placeholder="meta keywordsに使用されます(半角カンマ区切りで入力してください）"/>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ナビメニュー</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/2 p-1">
                                    <Checkbox inputId="show_in_header_navimenu" name="show_in_header_navimenu" binary v-model="settingForm.show_in_header_navimenu" />
                                    <label class="ml-2" for="show_in_header_navimenu">ナビメニューに表示する</label>
                                </div>
                                <div class="w-1/2 p-1">
                                    <Checkbox inputId="show_in_footer_navimenu" name="show_in_footer_navimenu" binary v-model="settingForm.show_in_footer_navimenu" />
                                    <label class="ml-2" for="show_in_footer_navimenu">下部ナビメニューに表示する</label>
                                </div>
                            </div>
                        </div>
                        <p class="pt-4">上部メニュー、下部メニューへの表示設定です</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">サイトマップ</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Checkbox inputId="show_in_site_map" binary name="show_in_site_map" v-model="settingForm.show_in_site_map" />
                        <label class="ml-2" for="show_in_site_map">サイトマップに載せる</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">フッター</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Checkbox inputId="show_sns" binary name="show_sns" v-model="settingForm.show_sns" />
                        <label class="ml-2" for="show_sns">SNSボタンを表示する</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">共通フッター</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="pb-3">
                            <Checkbox inputId="show_footer_index" binary name="show_footer_index" v-model="settingForm.show_footer_index" />
                            <label class="ml-2" for="show_footer_index">新着情報TOP・一覧表示に共通フッターを表示する</label>
                        </div>
                        <div class="pt-3">
                            <Checkbox inputId="show_footer_articles" name="show_footer_articles" binary v-model="settingForm.show_footer_articles" />
                            <label class="ml-2" for="show_footer_articles">全記事に共通フッターを表示する</label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">見出し画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <ImageSelector name="heading_image" :value="settingForm.heading_image"/>
                        </div>
                        <p class="pt-4">推奨サイズは横1920px以上、縦360px以上です</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">見出し画像の表示</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="show_heading_image_yes" name="show_heading_image" :value="1" v-model="settingForm.show_heading_image"/>
                        <label class="ml-2" for="show_heading_image_yes">表示する</label>
                        <RadioButton inputId="show_heading_image_no" name="show_heading_image" :value="0" class="ms-[37px]" v-model="settingForm.show_heading_image"/>
                        <label class="ml-2" for="show_heading_image_no">表示しない</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">デザイン</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[24px] w-[60%] border-l">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="py-4" v-for="index in 6" :key="index">
                                <div class="w-[171px] h-[91px] bg-[#D9D9D9] py-4"></div>
                                <div class="pt-2">
                                    <RadioButton inputId="design_type" name="design_type" :value="index" v-model="settingForm.design_type"/>
                                    <label class="ml-2" :for="'design_type' + index">デザイン（1カラム）{{ index }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">表示件数</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Select v-model="settingForm.per_page" name="per_page" :options="maxViewOptions" option-label="label" option-value="value" class="h-[38px] w-full"></Select>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">記事数</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="show_total_number_yes" name="show_total_number" :value="1" v-model="settingForm.show_total_number"/>
                        <label class="ml-2" for="show_total_number_yes">表示しない</label>
                        <RadioButton inputId="show_total_number_no" name="show_total_number" :value="0" class="ms-[37px]" v-model="settingForm.show_total_number"/>
                        <label class="ml-2" for="show_total_number_no">表示する</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">年月アーカイブ</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Checkbox inputId="show_archive" binary v-model="settingForm.show_archive" name="show_archive"/>
                        <label class="ml-2" for="show_archive">年月アーカイブを表示する</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">公開日時の表示</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Checkbox inputId="show_published_at" name="show_published_at" binary v-model="settingForm.show_published_at" />
                        <label class="ml-2" for="show_published_at">公開日時を表示しない</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">最終更新日の表示</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Checkbox inputId="show_updated_at" name="show_updated_at" binary v-model="settingForm.show_updated_at" />
                        <label class="ml-2" for="show_updated_at">最終更新日を表示する</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">署名</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[26px] pb-[12px] w-full border-l">
                        <p class="pb-3">署名(上部)</p>
                        <CkEditor
                            v-model="settingForm.top_signature"
                            name="top_signature"
                            tag-name="textarea"
                            class="border border-gray-300 rounded-lg p-4 shadow-lg"
                        />
                        <input type="hidden" name="top_signature" :value="settingForm.top_signature">
                        <p class="pb-3 pt-6">署名(下部)</p>
                        <CkEditor
                            v-model="settingForm.bottom_signature"
                            name="bottom_signature"
                            tag-name="textarea"
                            class="border border-gray-300 rounded-lg p-4 shadow-lg"
                        />
                        <p class="pt-6">記事が選択しているカテゴリに『カテゴリ選択時テキスト』と『リンク先』が設定されている場合、署名(上部)と署名(下部)の間に表示されます。</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">サブナビゲーション</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <Select v-model="settingForm.subnavigation_id" :options="subnavigations" optionLabel="name" placeholder="選択してください" class="h-[38px] w-full"  />
                        <input hidden name="subnavigation_id" :value="settingForm.subnavigation_id?.id">
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">アクセス制限</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[28px] pb-[12px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/2 p-1">
                                    <label class="mr-2" for="account">アカウント</label>
                                    <InputText name="account" v-model="settingForm.account" maxLength="30"/>
                                </div>
                                <div class="w-1/2 p-1">
                                    <label class="mr-2" for="password">パスワード</label>
                                    <InputText name="password" v-model="settingForm.password" maxLength="30"/>
                                </div>
                            </div>
                        </div>
                        <p class="pt-4">一覧・詳細ページにパスワードでロックすることが出来ます</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">独自＜head＞タグ内容</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Textarea class="w-full h-[108px]" v-model="settingForm.custom_head_tag" name="custom_head_tag"/>
                        <p class="pt-3">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
                    </div>
                </div>

                <h1 class="text-[22px] font-semibold leading-[33px] mt-10 mb-2">テキスト設定</h1>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">上部タイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.top_subtitle" name="top_subtitle" maxLength="50" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">上部サブタイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.top_subtitle" name="top_subtitle" maxLength="80" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">上部テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Textarea class="w-full h-[108px]" v-model="settingForm.top_text" name="top_text" maxlength="50"/>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <div class="flex flex-col items-center justify-center">
                            <span>上部タイトル・</span>
                            <span>サブタイトルの表示位置</span>
                        </div>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[44px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/4">
                                    <RadioButton inputId="top_title_position_left" name="top_title_position" :value="1" v-model="settingForm.top_title_position" />
                                    <label class="ml-2" for="top_title_position_left">左揃え</label>
                                </div>
                                <div class="w-1/4">
                                    <RadioButton inputId="top_title_position_center" name="top_title_position" :value="2" v-model="settingForm.top_title_position" />
                                    <label class="ml-2" for="top_title_position_center">中央揃え</label>
                                </div>
                                <div class="w-2/4">
                                    <RadioButton inputId="top_title_position_right" name="top_title_position" :value="3" v-model="settingForm.top_title_position" />
                                    <label class="ml-2" for="top_title_position_right">右揃え</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">上部テキストの表示位置</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[44px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/4">
                                    <RadioButton inputId="top_text_position_left" name="top_text_position" :value="1" v-model="settingForm.top_text_position" />
                                    <label class="ml-2" for="top_text_position_left">左揃え</label>
                                </div>
                                <div class="w-1/4">
                                    <RadioButton inputId="top_text_position_center" name="top_text_position" :value="2" v-model="settingForm.top_text_position" />
                                    <label class="ml-2" for="top_text_position_center">中央揃え</label>
                                </div>
                                <div class="w-2/4">
                                    <RadioButton inputId="top_text_position_right" name="top_text_position" :value="3" v-model="settingForm.top_text_position" />
                                    <label class="ml-2" for="top_text_position_right">右揃え</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">下部タイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.bottom_title" name="bottom_title" maxLength="50" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">下部サブタイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.bottom_subtitle" name="bottom_subtitle" maxLength="50" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">下部テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Textarea class="w-full h-[108px]" v-model="settingForm.bottom_text" name="bottom_text" maxlength="50"/>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <div class="flex flex-col items-center justify-center">
                            <span>下部タイトル・</span>
                            <span>サブタイトルの表示位置</span>
                        </div>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[44px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/4">
                                    <RadioButton inputId="bottom_title_position_left" name="bottom_title_position" :value="1" v-model="settingForm.bottom_title_position" />
                                    <label class="ml-2" for="bottom_title_position_left">左揃え</label>
                                </div>
                                <div class="w-1/4">
                                    <RadioButton inputId="bottom_title_position_center" name="bottom_title_position" :value="2" v-model="settingForm.bottom_title_position" />
                                    <label class="ml-2" for="bottom_title_position_center">中央揃え</label>
                                </div>
                                <div class="w-2/4">
                                    <RadioButton inputId="bottom_title_position_right" name="bottom_title_position" :value="3" v-model="settingForm.bottom_title_position" />
                                    <label class="ml-2" for="bottom_title_position_right">右揃え</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">下部テキストの表示位置</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[38px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div class="w-1/4">
                                    <RadioButton inputId="bottom_text_position_left" name="bottom_text_position" :value="1" v-model="settingForm.bottom_text_position" />
                                    <label class="ml-2" for="bottom_text_position_left">左揃え</label>
                                </div>
                                <div class="w-1/4">
                                    <RadioButton inputId="bottom_text_position_center" name="bottom_text_position" :value="2" v-model="settingForm.bottom_text_position" />
                                    <label class="ml-2" for="bottom_text_position_center">中央揃え</label>
                                </div>
                                <div class="w-2/4">
                                    <RadioButton inputId="bottom_text_position_right" name="bottom_text_position" :value="3" v-model="settingForm.bottom_text_position" />
                                    <label class="ml-2" for="bottom_text_position_right">右揃え</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="text-[22px] font-semibold leading-[33px] mt-10 mb-2">紹介エリア</h1>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">タイトル</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model="settingForm.introduction_title" name="introduction_title" maxLength="50" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <ImageSelector name="introduction_image" :value="settingForm.introduction_image"/>
                        </div>
                        <p class="pt-4">推奨サイズは横1920px以上、縦360px以上です</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">紹介文</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <CkEditor name="introduction" v-model="settingForm.introduction" />
                    </div>
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import Textarea from 'primevue/textarea'
import {reactive, defineProps, ref} from 'vue'
import CkEditor from '@/components/parts/common/CkEditor.vue'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps({
    path: String,
    tags: Array,
    snses: Array,
    csrfToken: String,
    successmessage: String,
    errormessage: Array,
    oldInput: Object,
    dataUpdate: Object,
    subnavigations: Object,
    backPath: String
})

const dataUpdate = reactive(props.dataUpdate)

const subNavigationOptionSelect = reactive(props.subnavigations.find((value) => {
    if (dataUpdate?.subnavigation_id?.id)
        return value.id === dataUpdate?.subnavigation_id?.id
    return value.id === dataUpdate?.subnavigation_id
}))

const settingForm = reactive({
    ...props.dataUpdate,
    subnavigation_id: subNavigationOptionSelect
});

const maxViewOptions = ref([
    { value: 10, label: '10件' },
    { value: 20, label: '20件' },
    { value: 30, label: '50件' },
])

const onSubmit = async (e) => {
    e.target.submit()
}
</script>

<style scoped>

:deep(.ck.ck-editor__editable_inline) {
    min-height: 504px;
}
</style>
