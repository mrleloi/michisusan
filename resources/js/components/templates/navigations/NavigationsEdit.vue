<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">新規追加</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center mb-6">
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
                <p class="text-[22px] font-semibold font-hiragino mb-4">共通設定</p>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">サブナビゲーション名</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <InputText class="w-full" v-model.trim="formData.name" name="name" maxLength="255" placeholder="選択してください"/>
                        </div>
                        <p class="text-red-500 text-[12px] mt-2" v-if="props.errormessage?.name?.length">{{props.errormessage?.name?.[0]}}</p>
                        <p class="text-[14px] text-black-500 mt-4">管理画面の一覧で分かりやすい名称を入力してください</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">起点ページ</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Select
                            v-model="page"
                            :options="listPages"
                            optionLabel="label"
                            placeholder="選択してください"
                            class="w-full"
                        />
                        <input type="hidden" name="start_page_id" :value="page.key" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ローディング画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <ImageSelector name="loading_image" :value="formData.loading_image"/>
                        <p class="text-[14px] text-black-500 mt-4">推奨サイズは横400px以上、縦88px以上です</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては透過PNGが必須となります</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">電話番号</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="bg-white space-y-4 flex justify-between items-center">
                            <div class="mt-3 mr-8">
                                <span class="w-full">(1)</span>
                            </div>
                            <div class="flex-1">
                                <InputText v-model="formData.common_tel_1" name="common_tel_1" placeholder="電話番号"
                                           class="w-full"/>
                            </div>
                            <div class="flex-1 mx-1">
                                <InputText v-model="formData.common_tel_1_header_note" name="common_tel_1_header_note" placeholder="上部備考"
                                           class="w-full"/>
                            </div>
                            <div class="flex-1">
                                <InputText v-model="formData.common_tel_1_footer_note" name="common_tel_1_footer_note" placeholder="下部備考"
                                           class="w-full"/>
                            </div>
                        </div>
                        <div class="bg-white space-y-1 flex justify-between items-center">
                            <div class="mr-8">
                                <span class="w-full">(2)</span>
                            </div>
                            <div class="flex-1">
                                <InputText v-model="formData.common_tel_2" name="common_tel_2" placeholder="電話番号"
                                           class="w-full"/>
                            </div>
                            <div class="flex-1 mx-1">
                                <InputText v-model="formData.common_tel_2_header_note" name="common_tel_2_header_note" placeholder="上部備考"
                                           class="w-full"/>
                            </div>
                            <div class="flex-1">
                                <InputText v-model="formData.common_tel_2_footer_note" name="common_tel_2_footer_note" placeholder="下部備考"
                                           class="w-full"/>
                            </div>
                        </div>
                        <p class="text-[14px] text-black-500 mt-6">全ページのヘッダーや追従フッターに表示されます</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては表示されない事があります</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">住所</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <InputText class="w-full" v-model.trim="formData.common_address" name="common_address" maxLength="255"/>
                        </div>
                        <p class="text-[14px] text-black-500 mt-4">全ページのヘッダーや追従フッターに表示されます</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては表示されない事があります</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">営業時間</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <InputText class="w-full" v-model.trim="formData.common_hour" name="common_hour" maxLength="255"/>
                        </div>
                        <p class="text-[14px] text-black-500 mt-4">全ページのヘッダーや追従フッターに表示されます</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては表示されない事があります</p>
                    </div>
                </div>

                <p class="text-[22px] font-semibold font-hiragino mt-12 mb-4">ヘッダー</p>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ヘッダーロゴ画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <ImageSelector name="header_logo_image" :value="formData.header_logo_image"/>
                        <p class="text-[14px] text-black-500 mt-4">推奨サイズは横400px以上、縦88px以上です</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては透過PNGが必須となります</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">表示設定</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center gap-2">
                            <Checkbox
                                v-model="formData.show_h_translation"
                                binary
                                inputId="show_h_translation"
                                name="show_h_translation"
                                value="true"
                            />
                            <label for="show_h_translation" class="ml-2">翻訳機能を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_h_tel_1"
                                binary
                                inputId="show_h_tel_1"
                                name="show_h_tel_1"
                            />
                            <label for="show_h_tel_1" class="ml-2">電話番号(1)を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_h_tel_2"
                                binary
                                inputId="show_h_tel_2"
                                name="show_h_tel_2"
                            />
                            <label for="show_h_tel_2" class="ml-2">電話番号(2)を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_h_address"
                                binary
                                inputId="show_h_address"
                                name="show_h_address"
                            />
                            <label for="show_h_address" class="ml-2">住所を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_h_hour"
                                binary
                                inputId="show_h_hour"
                                name="show_h_hour"
                            />
                            <label for="show_h_hour" class="ml-2">営業時間を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_h_button"
                                binary
                                inputId="show_h_button"
                                name="show_h_button"
                            />
                            <label for="show_h_button" class="ml-2">ボタンを表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_header_sns_on_pc"
                                binary
                                inputId="show_header_sns_on_pc"
                                name="show_header_sns_on_pc"
                            />
                            <label for="show_header_sns_on_pc" class="ml-2">PC時にもヘッダーSNSリンクを表示する</label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (1)</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="type_select" name="header_btn_1_link_type" :value="1" v-model="formData.header_btn_1_link_type" />
                                    <label class="ml-2" for="type_select">リストから選ぶ</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="type_input" name="header_btn_1_link_type" :value="2" v-model="formData.header_btn_1_link_type" />
                                    <label class="ml-2" for="type_input">直接入力する</label>
                                </div>
                            </div>
                        </div>
                        <div v-if="formData.header_btn_1_link_type == typeSelect" class="mt-4">
                            <Select
                                v-model="pageType"
                                :options="listPages"
                                :optionLabel="formatOptionLabel"
                                placeholder="選択してください"
                                class="w-full"
                            />
                            <input type="hidden" name="header_btn_1_link01" :value="pageType.key" />
                        </div>
                        <div v-if="formData.header_btn_1_link_type == typeInput" class="mt-4">
                            <InputText class="w-full" v-model.trim="formData.header_btn_1_link02" name="header_btn_1_link02" maxLength="255" placeholder="入力してください"/>
                        </div>
                        <div class="mt-6">
                            <p class="text-[14px]">ボタンに表示する文言</p>
                            <InputText class="w-full mt-2" v-model.trim="formData.header_btn_1_text" name="header_btn_1_text" maxLength="255"/>
                        </div>
                        <div class="flex-1 mt-4">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="same_window" name="header_btn_1_link_target" :value="1" v-model="formData.header_btn_1_link_target" />
                                    <label class="ml-2" for="same_window">同一ウインドウで開く</label>
                                </div>
                                <div class="w-1/4 p-1 ml-16">
                                    <RadioButton inputId="separate_window" name="header_btn_1_link_target" :value="2" v-model="formData.header_btn_1_link_target" />
                                    <label class="ml-2" for="separate_window">別ウインドウで開く</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (2)</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="type_select_2" name="header_btn_2_link_type" :value="1" v-model="formData.header_btn_2_link_type" />
                                    <label class="ml-2" for="type_select_2">リストから選ぶ</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="type_input_2" name="header_btn_2_link_type" :value="2" v-model="formData.header_btn_2_link_type" />
                                    <label class="ml-2" for="type_input_2">直接入力する</label>
                                </div>
                            </div>
                        </div>
                        <div v-if="formData.header_btn_2_link_type == typeSelect" class="mt-4">
                            <Select
                                v-model="page2Type"
                                :options="listPages"
                                :optionLabel="formatOptionLabel"
                                placeholder="選択してください"
                                class="w-full"
                            />
                            <input type="hidden" name="header_btn_2_link01" :value="page2Type.key" />
                        </div>
                        <div v-if="formData.header_btn_2_link_type == typeInput" class="mt-4">
                            <InputText class="w-full" v-model.trim="formData.header_btn_2_link02" name="header_btn_2_link02" maxLength="255" placeholder="入力してください"/>
                        </div>
                        <div class="mt-6">
                            <p class="text-[14px]">ボタンに表示する文言</p>
                            <InputText class="w-full mt-2" v-model.trim="formData.header_btn_2_text" name="header_btn_2_text" maxLength="255"/>
                        </div>
                        <div class="flex-1 mt-4">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="same_window_2" name="header_btn_2_link_target" :value="1" v-model="formData.header_btn_2_link_target" />
                                    <label class="ml-2" for="same_window_2">同一ウインドウで開く</label>
                                </div>
                                <div class="w-1/4 p-1 ml-16">
                                    <RadioButton inputId="separate_window_2" name="header_btn_2_link_target" :value="2" v-model="formData.header_btn_2_link_target" />
                                    <label class="ml-2" for="separate_window_2">別ウインドウで開く</label>
                                </div>
                            </div>
                            <p class="mt-4">『ボタンに表示する文言』が空欄の場合は表示されません</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">デフォルトの表示位置</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="text_align_left" name="header_text_align_flag" :value="1" v-model="formData.header_text_align_flag" />
                                    <label class="ml-2" for="text_align_left">左揃え</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="text_align_center" name="header_text_align_flag" :value="2" v-model="formData.header_text_align_flag" />
                                    <label class="ml-2" for="text_align_center">中央揃え</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="text_align_right" name="header_text_align_flag" :value="3" v-model="formData.header_text_align_flag" />
                                    <label class="ml-2" for="text_align_right">右揃え</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-[22px] font-semibold font-hiragino mt-12 mb-4">ヘッダーメニュー</p>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">文字色</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[32px] w-full border-l">
                        <ColorPicker v-model="formData.header_menu_text_color" />
                        <input type="hidden" name="header_menu_text_color" :value="formData.header_menu_text_color" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">フォント種</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[32px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left item-center">
                                <div class="w-1/5 mt-2">
                                    <span>タイトルフォント</span>
                                </div>
                                <div class="w-2/5">
                                    <Select
                                        v-model="fontTitle"
                                        :options="listFonts"
                                        optionLabel="name"
                                        placeholder="選択してください"
                                        class="w-full"
                                    />
                                    <input type="hidden" name="header_menu_title_font" :value="fontTitle.id" />
                                    <p class="mt-4">フォントのサンプル</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 mt-6">
                            <div class="flex justify-left item-center">
                                <div class="w-1/5 mt-2">
                                    <span>本文フォント</span>
                                </div>
                                <div class="w-2/5">
                                    <Select
                                        v-model="fontBody"
                                        :options="listFonts"
                                        optionLabel="name"
                                        placeholder="選択してください"
                                        class="w-full"
                                    />
                                    <input type="hidden" name="header_menu_body_font" :value="fontBody.id" />
                                    <p class="mt-4">フォントのサンプル</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">文字の太さ</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Select
                            v-model="fontWeight"
                            :options="listFontWeights"
                            optionLabel="name"
                            placeholder="選択してください"
                            class="w-[30%]"
                        />
                        <input type="hidden" name="header_menu_font_weight" :value="fontWeight.id" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">区切り線</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Select
                            v-model="divider"
                            :options="listFontWeights"
                            optionLabel="name"
                            placeholder="選択してください"
                            class="w-full"
                        />
                        <input type="hidden" name="header_menu_divider" :value="divider.id" />
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ホバー時アニメーション</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Select
                            v-model="animation"
                            :options="listAnimations"
                            optionLabel="label"
                            placeholder="選択してください"
                            class="w-[30%]"
                        />
                        <input type="hidden" name="header_menu_hover_animation" :value="animation.key" />
                        <div class="pt-4 flex gap-20">
                            <div class="flex gap-4">
                                <p class="mt-1">文字色</p>
                                <ColorPicker
                                    v-model="formData.header_menu_hover_text_color"
                                />
                                <input type="hidden" name="header_menu_hover_text_color" :value="formData.header_menu_hover_text_color" />
                            </div>
                            <div class="flex gap-4">
                                <p class="mt-1">ライン・背景色</p>
                                <ColorPicker
                                    v-model="formData.header_menu_hover_line_color"
                                />
                                <input type="hidden" name="header_menu_hover_line_color" :value="formData.header_menu_hover_line_color" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px]">
                        <span class="text-base">スマホメニュー</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4">
                                    <RadioButton inputId="show_smartphone_menus_yes" name="show_smartphone_menus" :value="1" v-model="formData.show_smartphone_menus" />
                                    <label class="ml-2" for="show_smartphone_menus_yes">リストから選ぶ</label>
                                </div>
                                <div class="w-1/4">
                                    <RadioButton inputId="show_smartphone_menus_no" name="show_smartphone_menus" :value="0" v-model="formData.show_smartphone_menus" />
                                    <label class="ml-2" for="show_smartphone_menus_no">直接入力する</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (1)</span>
                    </div>
                    <SpMenusFieldEdit
                        class="py-5 px-4 flex gap-2 flex-col"
                        :inputId="`menu1`"
                        :pages=listPages
                        :formData="formData"
                        :subSpMenus="subSpMenus[0]"
                    />
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (2)</span>
                    </div>
                    <SpMenusFieldEdit
                        class="py-5 px-4 flex gap-2 flex-col"
                        :inputId="`menu2`"
                        :pages=listPages
                        :formData="formData"
                        :subSpMenus="subSpMenus[1]"
                    />
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (3)</span>
                    </div>
                    <SpMenusFieldEdit
                        class="py-5 px-4 flex gap-2 flex-col"
                        :inputId="`menu3`"
                        :pages=listPages
                        :formData="formData"
                        :subSpMenus="subSpMenus[2]"
                    />
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (4)</span>
                    </div>
                    <SpMenusFieldEdit
                        class="py-5 px-4 flex gap-2 flex-col"
                        :inputId="`menu4`"
                        :pages=listPages
                        :formData="formData"
                        :subSpMenus="subSpMenus[3]"
                    />
                </div>

                <p class="text-[22px] font-semibold font-hiragino mt-12 mb-4">追従フッター</p>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ヘッダーロゴ画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <ImageSelector name="footer_logo_image" :value="formData.footer_logo_image"/>
                        <p class="text-[14px] text-black-500 mt-4">推奨サイズは横400px以上、縦88px以上です</p>
                        <p class="text-[14px] text-black-500">デザインテンプレートの種類によっては透過PNGが必須となります</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">表示設定</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center gap-2">
                            <Checkbox
                                v-model="formData.show_f_translation"
                                binary
                                inputId="show_f_translation"
                                name="show_f_translation"
                            />
                            <label for="show_f_translation" class="ml-2">追従フッターを表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_f_tel_1"
                                binary
                                inputId="show_f_tel_1"
                                name="show_f_tel_1"
                            />
                            <label for="show_f_tel_1" class="ml-2">電話番号(1)を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_f_tel_2"
                                binary
                                inputId="show_f_tel_2"
                                name="show_f_tel_2"
                            />
                            <label for="show_f_tel_2" class="ml-2">電話番号(2)を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_f_address"
                                binary
                                inputId="show_f_address"
                                name="show_f_address"
                            />
                            <label for="show_f_address" class="ml-2">営業時間を表示する</label>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <Checkbox
                                v-model="formData.show_f_hour"
                                binary
                                inputId="show_f_hour"
                                name="show_f_hour"
                            />
                            <label for="show_f_hour" class="ml-2">ボタンを表示する</label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (1)</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_type_select" name="footer_btn_1_link_type" :value="1" v-model="formData.footer_btn_1_link_type" />
                                    <label class="ml-2" for="footer_type_select">リストから選ぶ</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_type_input" name="footer_btn_1_link_type" :value="2" v-model="formData.footer_btn_1_link_type" />
                                    <label class="ml-2" for="footer_type_input">直接入力する</label>
                                </div>
                            </div>
                        </div>
                        <div v-if="formData.footer_btn_1_link_type == typeSelect" class="mt-4">
                            <Select
                                v-model="pageType1"
                                :options="listPages"
                                :optionLabel="formatOptionLabel"
                                placeholder="選択してください"
                                class="w-full"
                            />
                            <input type="hidden" name="footer_btn_1_link01" :value="pageType1.key" />
                        </div>
                        <div v-if="formData.footer_btn_1_link_type == typeInput" class="mt-4">
                            <InputText class="w-full" v-model.trim="formData.footer_btn_1_link02" name="footer_btn_1_link02" maxLength="255" placeholder="入力してください"/>
                        </div>
                        <div class="mt-6">
                            <p class="text-[14px]">ボタンに表示する文言</p>
                            <InputText class="w-full mt-2" v-model.trim="formData.footer_btn_1_text" name="footer_btn_1_text" maxLength="255"/>
                        </div>
                        <div class="flex-1 mt-4">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_same_window" name="footer_btn_1_link_target" :value="1" v-model="formData.footer_btn_1_link_target" />
                                    <label class="ml-2" for="footer_same_window">同一ウインドウで開く</label>
                                </div>
                                <div class="w-1/4 p-1 ml-16">
                                    <RadioButton inputId="footer_separate_window" name="footer_btn_1_link_target" :value="2" v-model="formData.footer_btn_1_link_target" />
                                    <label class="ml-2" for="footer_separate_window">別ウインドウで開く</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ボタン設定 (2)</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_2_type_select" name="footer_btn_2_link_type" :value="1" v-model="formData.footer_btn_2_link_type" />
                                    <label class="ml-2" for="footer_type_select">リストから選ぶ</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_2_type_input" name="footer_btn_2_link_type" :value="2" v-model="formData.footer_btn_2_link_type" />
                                    <label class="ml-2" for="footer_type_input">直接入力する</label>
                                </div>
                            </div>
                        </div>
                        <div v-if="formData.footer_btn_2_link_type == typeSelect" class="mt-4">
                            <Select
                                v-model="pageType2"
                                :options="listPages"
                                :optionLabel="formatOptionLabel"
                                placeholder="選択してください"
                                class="w-full"
                            />
                            <input type="hidden" name="footer_btn_2_link01" :value="pageType2.key" />
                        </div>
                        <div v-if="formData.footer_btn_2_link_type == typeInput" class="mt-4">
                            <InputText class="w-full" v-model.trim="formData.footer_btn_2_link02" name="footer_btn_2_link02" maxLength="255" placeholder="入力してください"/>
                        </div>
                        <div class="mt-6">
                            <p class="text-[14px]">ボタンに表示する文言</p>
                            <InputText class="w-full mt-2" v-model.trim="formData.footer_btn_2_text" name="footer_btn_2_text" maxLength="255"/>
                        </div>
                        <div class="flex-1 mt-4">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_2_same_window" name="footer_btn_2_link_target" :value="1" v-model="formData.footer_btn_2_link_target" />
                                    <label class="ml-2" for="footer_2_same_window">同一ウインドウで開く</label>
                                </div>
                                <div class="w-1/4 p-1 ml-16">
                                    <RadioButton inputId="footer_2_separate_window" name="footer_btn_2_link_target" :value="2" v-model="formData.footer_btn_2_link_target" />
                                    <label class="ml-2" for="footer_2_separate_window">別ウインドウで開く</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">フッターナビ項目</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex-1">
                            <div class="flex justify-left">
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_text_align_left" name="footer_text_align_flag" :value="1" v-model="formData.footer_text_align_flag" />
                                    <label class="ml-2" for="footer_text_align_left">長い項目は省略する</label>
                                </div>
                                <div class="w-1/4 p-1">
                                    <RadioButton inputId="footer_text_align_center" name="footer_text_align_flag" :value="2" v-model="formData.footer_text_align_flag" />
                                    <label class="ml-2" for="footer_text_align_center">長い項目も省略しない</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <StickRegistButton :back-path="backPath" text-back-btn="一覧に戻る"/>
        </form>
    </div>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import ColorPicker from 'primevue/colorpicker'
import SpMenusFieldEdit from '@/components/parts/common/SpMenusFieldEdit.vue'
import {reactive, defineProps, ref} from 'vue'

const props = defineProps(['navigation', 'subSpMenus', 'fonts', 'weights', 'animations', 'pages', 'path', 'csrfToken', 'errormessage', 'oldInput',
    'selectedPage', 'backPath', 'selectedPageType', 'selectedFontTitle', 'selectedFontBody', 'selectedFontWeight', 'selectedDivider',
    'selectedAnimation', 'setting', 'pages', 'selectedPageType1', 'selectedPageType2'])
const navigation = reactive(props.navigation)
const subSpMenus = reactive(props.subSpMenus)
const backPath = props.backPath
const listPages = ref([...props.pages])
const selectedPage = ref(listPages.value.find((value) => {
    return value.key == (props.oldInput?.start_page_id || navigation?.start_page_id)
}))
const page = ref(selectedPage.value ? selectedPage.value : '')

const selectedPageType = ref(listPages.value.find((value) => {
    return value.key == (props.oldInput?.header_btn_1_link01 || navigation?.header_btn_1_link01)
}))
const pageType = ref(selectedPageType.value ? selectedPageType.value : '')

const selectedPage2Type = ref(listPages.value.find((value) => {
    return value.key == (props.oldInput?.header_btn_2_link01 || navigation?.header_btn_2_link01)
}))
const page2Type = ref(selectedPage2Type.value ? selectedPage2Type.value : '')

const listFonts = ref([...props.fonts])
const selectedFontTitle = ref(listFonts.value.find((value) => {
    return value.id == (props.oldInput?.header_menu_title_font || navigation?.header_menu_title_font)
}))
const fontTitle = ref(selectedFontTitle.value ? selectedFontTitle.value : '')

const selectedFontBody = ref(listFonts.value.find((value) => {
    return value.id == (props.oldInput?.header_menu_body_font || navigation?.header_menu_body_font)
}))
const fontBody = ref(selectedFontBody.value ? selectedFontBody.value : '')

const listFontWeights = ref([...props.weights])
const selectedFontWeight = ref(listFontWeights.value.find((value) => {
    return value.id == (props.oldInput?.header_menu_font_weight || navigation?.header_menu_font_weight)
}))
const fontWeight = ref(selectedFontWeight.value ? selectedFontWeight.value : '')

const selectedDivider = ref(listFontWeights.value.find((value) => {
    return value.id == (props.oldInput?.header_menu_divider || navigation?.header_menu_divider)
}))
const divider = ref(selectedDivider.value ? selectedDivider.value : '')

const listAnimations = ref([...props.animations])
const selectedAnimation = ref(listAnimations.value.find((value) => {
    return value.key == (props.oldInput?.header_menu_hover_animation || navigation?.header_menu_hover_animation)
}))
const animation = ref(selectedAnimation.value ? selectedAnimation.value : '')

const selectedPageType1 = ref(listPages.value.find((value) => {
    return value.key == (props.oldInput?.footer_btn_1_link01 || navigation?.footer_btn_1_link01)
}))
const pageType1 = ref(selectedPageType1.value ? selectedPageType1.value : '')

const selectedPageType2 = ref(listPages.value.find((value) => {
    return value.key == (props.oldInput?.footer_btn_2_link01 || navigation?.footer_btn_2_link01)
}))
const pageType2 = ref(selectedPageType2.value ? selectedPageType2.value : '')

const typeSelect = 1
const typeInput = 2
const alignLeft = 1
const textColor = '#6B7280'
const formData = reactive({
    ...props.navigation,
    start_page_id: selectedPage,
    show_h_translation: !!props.navigation.show_h_translation,
    show_h_tel_1: !!props.navigation.show_h_tel_1,
    show_h_tel_2: !!props.navigation.show_h_tel_2,
    show_h_address: !!props.navigation.show_h_address,
    show_h_hour: !!props.navigation.show_h_hour,
    show_h_button: !!props.navigation.show_h_hour,
    show_header_sns_on_pc: !!props.navigation.show_header_sns_on_pc,
    header_btn_1_link01: selectedPageType,
    header_menu_title_font: fontTitle,
    header_menu_body_font: fontBody,
    header_menu_font_weight: fontWeight,
    header_menu_divider: divider,
    show_f_translation: !!props.navigation.show_f_translation,
    show_f_tel_1: !!props.navigation.show_f_tel_1,
    show_f_tel_2: !!props.navigation.show_f_tel_2,
    show_f_address: !!props.navigation.show_f_address,
    show_f_hour: !!props.navigation.show_f_hour,
    footer_btn_1_link01: selectedPageType1,
    footer_btn_2_link01: selectedPageType2,
})

const formatOptionLabel = (page) => `${page.label}: ${page.uri}`

const onSubmit = async e => {
    e.target.submit()
}
</script>
