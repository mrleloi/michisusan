import { createApp } from 'vue'
import { createPinia } from 'pinia'

import PrimeVue from 'primevue/config'
import Lara from '@primevue/themes/lara'

import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import SelectOption from 'primevue/select'
import Textarea from 'primevue/textarea'

import 'primeicons/primeicons.css'
import 'animate.css'

import ManageLayout from '@/components/templates/layouts/Manage.vue'
import ManageEditLayout from '@/components/templates/layouts/ManageEdit.vue'
import ManageEditHasNavLayout from '@/components/templates/layouts/ManageEditHasNav.vue'
import PageList from '@/components/templates/pages/PageList.vue'
import PageBatchButtons from '@/components/templates/pages/BatchButtons.vue'
import HeaderMenu from '@/components/parts/layouts/manage/HeaderMenu.vue'
import SortableList from '@/components/parts/common/list/SortableList.vue'
import Paginator from '@/components/parts/common/list/Paginator.vue'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import FileSelector from '@/components/parts/common/FileSelector.vue'
import DialogImageSelector from '@/components/parts/common/DialogImageSelector.vue'
import CkEditor from '@/components/parts/common/CkEditor.vue'
import InputTextWithCount from '@/components/parts/common/InputTextWithCount.vue'
import RadioButtonWithImage from '@/components/parts/common/RadioButtonWithImage.vue'
import CategorySelector from '@/components/parts/common/category_selector/CategorySelector.vue'
import NewsArticlesListPaginator from '@/components/templates/news-articles/NewsArticlesListPaginator.vue'
import ExternalLinkForm from '@/components/templates/pages/ExternalLinkForm.vue'
import NavibarSetting from '@/components/templates/pages/NavibarSetting.vue'
import Dropdown from '@/components/parts/common/Dropdown.vue'
import NewArticlesSettingDialog from '@/components/templates/news-articles/NewArticlesSettingDialog.vue'
import NewsArticleSortableList from '@/components/templates/news-articles/SortableList.vue'
import HeaderFilterList from '@/components/templates/news-articles/HeaderFilterList.vue'
import SettingTable from '@/components/templates/header-footer/SettingTable.vue'
import HeaderMenuSettingTable from '@/components/templates/header-footer/HeaderMenuSettingTable.vue'
import ShopItemFields from '@/components/templates/shop-items/ShopItemFields.vue'
import GalleryItemImages from '@/components/templates/gallery-items/GalleryItemImages.vue'
import StaffMemberFields from '@/components/templates/staff-members/StaffMemberFields.vue'
import RecruitingFields from '@/components/templates/recruitings/RecruitingFields.vue'
import InquiryFormFields from '@/components/templates/inquiry-forms/InquiryFormFields.vue'
import ImageList from '@/components/parts/common/list/ImageList.vue'
import VideoList from '@/components/parts/common/list/VideoList.vue'
import MailTestButton from '@/components/templates/inquiry-forms/MailTestButton.vue'

import Select from '@/components/parts/pv/Select.vue'
import Checkbox from '@/components/parts/pv/Checkbox.vue'
import RadioButton from '@/components/parts/pv/RadioButton.vue'
import InputNumber from '@/components/parts/pv/InputNumber.vue'
import MultiSelect from '@/components/parts/pv/MultiSelect.vue'
import ColorPicker from '@/components/parts/pv/ColorPicker.vue'
import Password from '@/components/parts/pv/Password.vue'
import DatePicker from '@/components/parts/pv/DatePicker.vue'

import NewsCategoriesSortableList from '@/components/templates/news-categories/NewsCategoriesSortableList.vue'
import NewsCategoriesHeaderFilterList from '@/components/templates/news-categories/NewsCategoriesHeaderFilterList.vue'
import NewsCategoriesAdd from '@/components/templates/news-categories/NewsCategoriesAdd.vue'
import NewsCategoriesEdit from '@/components/templates/news-categories/NewsCategoriesEdit.vue'
import BlogsPostsSettingDialog from '@/components/templates/blogs-posts/BlogsPostsSettingDialog.vue'
import BlogHeaderFilterList from '@/components/templates/blogs-posts/BlogHeaderFilterList.vue'
import NewsArticlesSetting from '@/components/templates/news-articles/NewsArticlesSetting.vue'
import BlogsCategoriesSortableList from '@/components/templates/blogs-categories/BlogsCategoriesSortableList.vue'
import BlogsCategoriesHeaderFilterList from '@/components/templates/blogs-categories/BlogsCategoriesHeaderFilterList.vue'
import BlogsCategoriesAdd from '@/components/templates/blogs-categories/BlogsCategoriesAdd.vue'
import BlogsCategoriesEdit from '@/components/templates/blogs-categories/BlogsCategoriesEdit.vue'
import BlogsTemplatesHeaderFilterList from '@/components/templates/blogs-templates/BlogsTemplatesHeaderFilterList.vue'
import BlogsTemplatesSortableList from '@/components/templates/blogs-templates/BlogsTemplatesSortableList.vue'
import BlogsTemplateSettingBasic from '@/components/templates/blogs-templates/BlogsTemplateSettingBasic.vue'
import BlogsTemplatesAdvanceSettings from '@/components/templates/blogs-templates/BlogsTemplatesAdvanceSettings.vue'
import BlogsTemplatePublicSettings from '@/components/templates/blogs-templates/BlogsTemplatePublicSettings.vue'
import BlogsTemplateExpandSettings from '@/components/templates/blogs-templates/BlogsTemplateExpandSettings.vue'
import BlogsTemplateSettingDialog from '@/components/templates/blogs-templates/BlogsTemplateSettingDialog.vue'
import BlogsSimpleAdd from '@/components/templates/blogs-posts/BlogsSimpleAdd.vue'
import BlogsSimpleEdit from '@/components/templates/blogs-posts/BlogsSimpleEdit.vue'
import BlogsSettingBasic from '@/components/templates/blogs-posts/BlogsSettingBasic.vue'
import PageSettingDialog from '@/components/templates/pages/PageSettingDialog.vue'
import PartsEditForm from '@/components/templates/site-parts/PartsEditForm.vue'
import PartsSettingDialog from '@/components/templates/site-parts/PartsSettingDialog.vue'
import SettingCssEdit from '@/components/templates/settings/SettingCssEdit.vue'
import SettingJsEdit from '@/components/templates/settings/SettingJsEdit.vue'
import EmbedScriptEdit from '@/components/templates/settings/EmbedScriptEdit.vue'
import SiteMapEdit from '@/components/templates/settings/SiteMapEdit.vue'
import SettingPaymentEdit from '@/components/templates/settings/SettingPaymentEdit.vue'
import SettingSnsEdit from '@/components/templates/settings/SettingSnsEdit.vue'
import SettingAnalyticEdit from '@/components/templates/settings/SettingAnalyticEdit.vue'
import TagsHeaderFilterList from '@/components/templates/tags/HeaderFilterList.vue'
import TagsAdd from '@/components/templates/tags/TagsAdd.vue'
import TagsEdit from '@/components/templates/tags/TagsEdit.vue'
import TagsSortableList from '@/components/templates/tags/SortableList.vue'
import DocumentFileForm from '@/components/templates/document-files/DocumentFileForm.vue'
import ImagesAdd from '@/components/templates/images/ImagesAdd.vue'
import ImagesEdit from '@/components/templates/images/ImagesEdit.vue'

import RedirectsAdd from '@/components/templates/redirects/RedirectsAdd.vue'
import RedirectsEdit from '@/components/templates/redirects/RedirectsEdit.vue'
import VideosAdd from '@/components/templates/videos/VideosAdd.vue'
import VideosEdit from '@/components/templates/videos/VideosEdit.vue'
import Dashboard from '@/components/templates/dashboard/Dashboard.vue'
import SettingsAdvanced from '@/components/templates/settings/SettingsAdvanced.vue'
import NavigationsAdd from '@/components/templates/navigations/NavigationsAdd.vue'
import NavigationsEdit from '@/components/templates/navigations/NavigationsEdit.vue'
import NewsArticlesPartsEditForm from '@/components/templates/news-articles/NewsArticlesPartsEditForm.vue'
import NewsArticlesPartsSettingDialog from '@/components/templates/news-articles/NewsArticlesPartsSettingDialog.vue'
import Front from '@/components/templates/front/Front.vue'

import { definePreset } from '@primevue/themes'

const app = createApp({
  components: {
    ManageLayout,
    ManageEditLayout,
    ManageEditHasNavLayout,
    HeaderMenu,
    SortableList,
    Paginator,
    ImageSelector,
    FileSelector,
    DialogImageSelector,
    CategorySelector,
    CkEditor,
    InputTextWithCount,
    RadioButtonWithImage,
    PageList,
    ImageList,
    VideoList,
    PageBatchButtons,
    ExternalLinkForm,
    NewArticlesSettingDialog,
    NewsArticleSortableList,
    NewsArticlesListPaginator,
    HeaderFilterList,
    ShopItemFields,
    GalleryItemImages,
    StaffMemberFields,
    RecruitingFields,
    InquiryFormFields,
    NewsCategoriesHeaderFilterList,
    NewsCategoriesSortableList,
    NewsCategoriesAdd,
    NewsCategoriesEdit,
    BlogsPostsSettingDialog,
    BlogHeaderFilterList,
    SelectOption,
    NavibarSetting,
    Dropdown,
    InputText,
    Textarea,
    Password,
    Checkbox,
    Select,
    SettingTable,
    HeaderMenuSettingTable,
    BlogsCategoriesHeaderFilterList,
    BlogsCategoriesSortableList,
    BlogsCategoriesAdd,
    BlogsCategoriesEdit,
    NewsArticlesSetting,
    BlogsTemplatesHeaderFilterList,
    BlogsTemplatesSortableList,
    BlogsTemplateSettingBasic,
    BlogsTemplatesAdvanceSettings,
    BlogsTemplatePublicSettings,
    BlogsTemplateExpandSettings,
    BlogsTemplateSettingDialog,
    BlogsSimpleAdd,
    BlogsSimpleEdit,
    PageSettingDialog,
    NewsArticlesPartsEditForm,
    NewsArticlesPartsSettingDialog,
    PartsEditForm,
    PartsSettingDialog,
    BlogsSettingBasic,
    SettingCssEdit,
    SettingJsEdit,
    EmbedScriptEdit,
    SettingPaymentEdit,
    SettingSnsEdit,
    SettingAnalyticEdit,
    SiteMapEdit,
    TagsHeaderFilterList,
    TagsAdd,
    TagsEdit,
    TagsSortableList,
    DocumentFileForm,
    ImagesAdd,
    ImagesEdit,
    RedirectsAdd,
    RedirectsEdit,
    VideosAdd,
    VideosEdit,
    Dashboard,
    SettingsAdvanced,
    NavigationsAdd,
    NavigationsEdit,
    MailTestButton,
    Front
  }
})

// button等のhtml5のタグと被る名前のコンポーネントはalias nameを変えないと動かない?
// ↑でなくてもコンポーネント単体で使う系統のものはpv_付けるようにしてます(input_text除く)
app.component('PvButton', Button)
app.component('PvSelect', Select)
app.component('PvCheckbox', Checkbox)
app.component('PvRadioButton', RadioButton)
app.component('PvMultiSelect', MultiSelect)
app.component('PvTextarea', Textarea)
app.component('PvColorPicker', ColorPicker)
app.component('PvInputNumber', InputNumber)
app.component('PvDatePicker', DatePicker)

const pinia = createPinia()
app.use(pinia)

app.use(PrimeVue, {
  theme: {
    preset: definePreset(Lara, {
      semantic: {
        primary: {
          50: '{blue.50}',
          100: '{blue.100}',
          200: '{blue.200}',
          300: '{blue.300}',
          400: '{blue.400}',
          500: '{blue.500}',
          600: '{blue.600}',
          700: '{blue.700}',
          800: '{blue.800}',
          900: '{blue.900}',
          950: '{blue.950}'
        }
      }
    }),
    options: {
      prefix: 'p',
      darkModeSelector: '.app-dark',
      cssLayer: false
    }
  }
})

app.mount('#app')
