<template>
  <div class="w-full">
    <div class="px-8">
      <h1>拡張設定</h1>
    </div>

    <div class="px-12 py-4">
      <table class="table-auto w-full border-collapse">
        <tbody>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              親ディレクトリ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <div class="flex flex-col gap-4">
                  <div class="directory-selector">
                    <template v-for="p in pages">
                      <div v-if="id != p.id" class="directory-selector-col">
                        <RadioButton
                          v-model="pageId"
                          :inputId="`page${p.id}`"
                          :name="`page${p.id}`"
                          :value="p.id"
                        />
                        <label :for="`page${p.id}`">
                          {{ p.title }} <br />{{ p.directory }}
                        </label>
                      </div>

                      <template v-for="c in p.children">
                        <div
                          v-if="id != c.id"
                          class="directory-selector-col ml-8"
                        >
                          <RadioButton
                            v-model="pageId"
                            :inputId="`page${c.id}`"
                            :name="`page${c.id}`"
                            :value="c.id"
                          />
                          <label :for="`page${c.id}`">
                            {{ c.title }} <br />{{ c.directory }}
                          </label>
                        </div>
                      </template>
                    </template>
                  </div>
                  <p>
                    ページを配置する階層を指定できます。関連度の高いページの下に配置しましょう
                  </p>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              ナビメニュー
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <div class="pb-3 flex gap-2 flex-col">
                  <CheckboxLabel
                    v-model="showTopNavi"
                    class="flex gap-1"
                    inputId="show_top_navi"
                    binary
                  >
                    上部ナビメニューに表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showSideNavi"
                    class="flex gap-1"
                    inputId="show_side_navi"
                    binary
                  >
                    サイドナビに表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showBottomNavi"
                    class="flex gap-1"
                    inputId="show_bottom_navi"
                    binary
                  >
                    下部ナビメニューに表示する
                  </CheckboxLabel>
                </div>
                <p>上部メニュー、サイドナビ、下部メニューへの表示設定です</p>
              </div>
            </td>
          </tr>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              同じカテゴリーのページ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showCategory"
                  class="flex gap-1"
                  inputId="show_category"
                  binary
                >
                  同じカテゴリーのページを表示する
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              関連ページ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showRelatedPage"
                  class="flex gap-1"
                  inputId="show_related_page"
                  binary
                >
                  関連ページを表示する<br />
                  (チェックを外すと他ページの『関連ページ』にも表示されなくなります)
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              関連タグ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showTag"
                  class="flex gap-1"
                  inputId="show_related_tag"
                  binary
                >
                  関連タグを表示する
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              サイトマップ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showSitemap"
                  class="flex gap-1"
                  inputId="show_sitemap"
                  binary
                >
                  サイトマップに載せる
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              共通サイドナビ
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showCommonSideNavi"
                  class="flex gap-1"
                  inputId="show_common_side_navi"
                  binary
                >
                  共通サイドナビを表示する
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              共通フッター
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showCommonFooter"
                  class="flex gap-1"
                  inputId="show_common_footer"
                  binary
                >
                  共通フッターを表示する
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              SEO診断
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <CheckboxLabel
                  v-model="showSeoAnalysis"
                  class="flex gap-1"
                  inputId="show_seo_analysis"
                  binary
                >
                  SEO診断に表示する
                </CheckboxLabel>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              アクセス制限
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <div class="pb-4">
                  アカウント：<InputText v-model="account" />
                </div>
                <div class="pb-4">
                  パスワード：<InputText v-model="password" />
                </div>
                <p>ページ毎にパスワードでロックすることが出来ます</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="w-full">
    <div class="px-8">
      <h1>画像関連</h1>
    </div>

    <div class="px-12 py-4">
      <table class="table-auto w-full border-collapse">
        <tbody>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              アイキャッチ画像
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <ImageSelector name="eye_catch" :value="eyeCatch" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="w-full">
    <div class="px-8">
      <h1>ヘッダー・フッター</h1>
    </div>

    <div class="px-12 py-4">
      <table class="table-auto w-full border-collapse">
        <tbody>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              ヘッダー
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <div class="flex gap-2 flex-col">
                  <CheckboxLabel
                    v-model="showHeader"
                    class="flex gap-1"
                    inputId="show_header"
                    binary
                  >
                    ヘッダーを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showHeaderLogo"
                    class="flex gap-1"
                    inputId="show_header_logo"
                    binary
                  >
                    ロゴを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showHeaderNavimenu"
                    class="flex gap-1"
                    inputId="show_header_navimenu"
                    binary
                  >
                    ナビメニューを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showHeaderMv"
                    class="flex gap-1"
                    inputId="show_header_mv"
                    binary
                  >
                    MVを表示する
                  </CheckboxLabel>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              フッター
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="p-4">
                <div class="flex gap-2 flex-col">
                  <CheckboxLabel
                    v-model="showFooter"
                    class="flex gap-1"
                    inputId="show_footer"
                    binary
                  >
                    フッターを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showFooterLogo"
                    class="flex gap-1"
                    inputId="show_footer_logo"
                    binary
                  >
                    ロゴを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showFooterNavimenu"
                    class="flex gap-1"
                    inputId="show_footer_navimenu"
                    binary
                  >
                    ナビメニューを表示する
                  </CheckboxLabel>
                  <CheckboxLabel
                    v-model="showFooterSns"
                    class="flex gap-1"
                    inputId="show_footer_sns"
                    binary
                  >
                    SNSボタンを表示する
                  </CheckboxLabel>
                </div>
              </div>
            </td>
          </tr>
          <tr class="bg-[#EFF3F8]">
            <td
              class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
            >
              サブナビゲーション
            </td>
            <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
              <div class="pt-4 pb-2 px-4">
                <div class="flex flex-col gap-4">
                  <div class="">
                    <Select v-model="subnavagationId" />
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import CheckboxLabel from '@/components/parts/common/Checkbox.vue'
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'
import Select from '@/components/parts/pv/Select.vue'
import InputText from 'primevue/inputtext'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import RadioButton from 'primevue/radiobutton'

const props = defineProps({
  pages: { type: Array }
})

const store = usePageSettingStore()
const {
  id,
  title,
  withSeoTitle,
  description,
  h1Text,
  tags,
  navigationName,
  directory,
  keywords,
  showTag,
  showCommonFooter,
  account,
  password,
  eyeCatch,
  pageId,
  showTopNavi,
  showSideNavi,
  showBottomNavi,
  showCategory,
  showRelatedPage,
  showRelatedTag,
  showSitemap,
  showCommonSideNavi,
  showSeoAnalysis,
  showHeader,
  showHeaderLogo,
  showHeaderNavimenu,
  showHeaderMv,
  showFooter,
  showFooterLogo,
  showFooterNavimenu,
  showFooterSns,
  subnavagationId
} = storeToRefs(store)
</script>

<style scoped>
.directory-selector {
  @apply flex flex-col bg-white max-h-[180px] overflow-auto border border-[#D1D5DB];
}

.directory-selector-col {
  @apply flex items-center gap-4 px-4 py-4 border border-[#D1D5DB];
}
</style>
