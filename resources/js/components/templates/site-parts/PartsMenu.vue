<template>
  <ul>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', HeadingSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-bookmark p-4" />
      </div>
      <p>見出し</p>
    </li>
    <li>
      <div
        class="flex items-center border-b pr-8 cursor-pointer"
        @click="$emit('update', TextSetting)"
      >
        <div class="flex min-w-[64px] justify-center items-center">
          <i class="pi pi-file-edit p-4" />
        </div>
        <p>テキスト</p>
      </div>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', ImageSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-image p-4" />
      </div>
      <p>画像</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-images p-4" />
      </div>
      <p>画像+テキスト</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-th-large p-4" />
      </div>
      <p>（画像+テキスト）×n</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-bars p-4" />
      </div>
      <p>ボタン</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-comment p-4" />
      </div>
      <p>会話</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-chevron-right p-4" />
      </div>
      <p>区切り線</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-table p-4" />
      </div>
      <p>テーブル</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-phone p-4" />
      </div>
      <p>Tel</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-map-marker p-4" />
      </div>
      <p>Map</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-link p-4" />
      </div>
      <p>外部参照</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-fast-forward p-4" />
      </div>
      <p>動画</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-wifi p-4" />
      </div>
      <p>ブログ</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-file-o p-4" />
      </div>
      <p>新着情報</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-envelope p-4" />
      </div>
      <p>お問い合わせ</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', GallerySetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-images p-4" />
      </div>
      <p>ギャラリー</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', MenuSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-list p-4" />
      </div>
      <p>メニュー</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', StaffMemberSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-user-edit p-4" />
      </div>
      <p>スタッフ</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', FaqSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-question-circle p-4" />
      </div>
      <p>よくある質問</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', ShopSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-building p-4" />
      </div>
      <p>企業・店舗情報</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', BeforeAfterSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-sync p-4" />
      </div>
      <p>ビフォーアフター</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', RecruitingSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-briefcase p-4" />
      </div>
      <p>リクルート</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-sliders-h p-4" />
      </div>
      <p>スライド</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-book p-4" />
      </div>
      <p>目次</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-replay p-4" />
      </div>
      <p>更新履歴</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-heart p-4" />
      </div>
      <p>お気に入り</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="p-4 flex min-w-[64px] justify-center items-center">
        <i class="text-xs pi pi-chevron-left" />
        <i class="text-xs pi pi-chevron-right" />
      </div>
      <p>HTML入力</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', CalendarSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-calendar p-4" />
      </div>
      <p>カレンダー</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', SNSSetting)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-users p-4" />
      </div>
      <p>SNS</p>
    </li>
    <li
      class="flex items-center border-b pr-8 cursor-pointer"
      @click="$emit('update', null)"
    >
      <div class="flex min-w-[64px] justify-center items-center">
        <i class="pi pi-eye p-4" />
      </div>
      <p>シミュレーション</p>
    </li>
  </ul>
</template>

<script setup>
import CalendarSetting from './Calendar/CalendarSetting.vue'
import HeadingSetting from './Heading/HeadingSetting.vue'
import SNSSetting from './SNS/SNSSetting.vue'
import TextSetting from './Text/TextSetting.vue'
import ImageSetting from './image/ImageSetting.vue'
import BeforeAfterSetting from './BeforeAfter/BeforeAfterSetting.vue'
import MenuSetting from './Menu/MenuSetting.vue'
import StaffMemberSetting from './StaffMember/StaffMemberSetting.vue'
import GallerySetting from './Gallery/GallerySetting.vue'
import ShopSetting from './Shop/ShopSetting.vue'
import FaqSetting from './Faq/FaqSetting.vue'
import RecruitingSetting from './recruiting/RecruitingSetting.vue'

defineEmits(['update'])
</script>
