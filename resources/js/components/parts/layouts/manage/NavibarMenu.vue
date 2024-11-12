<template>
  <Accordion
    :value="[]"
    multiple
    expandIcon="pi pi-chevron-right"
    collapseIcon="pi pi-chevron-down"
    :pt="{ content: '!p-0' }"
  >
    <AccordionPanel
      v-for="(menu, i) in menus"
      :value="i"
      :pt="{ content: '!p-0' }"
    >
      <AccordionHeader
        :class="{ '!block': !menu.contents }"
        :pt="{ root: '!flex-row-reverse !gap-4' }"
        @click="open(menu)"
      >
        <template #toggleicon>
          <span v-if="!menu.contents" />
        </template>

        <a :href="menu.to" class="flex flex-1 gap-2 items-center text-current">
          <i class="pi" :class="menu.icon" />
          <p class="flex-1">{{ menu.header }}</p>
        </a>
      </AccordionHeader>

      <AccordionContent>
        <Tree :value="menu.contents" class="w-full" :pt="{ root: '!p-0' }">
          <template #nodeicon="{ node }">
            <a :href="node.to">
              <i class="pi" :class="node.icon" />
            </a>
          </template>

          <template #default="{ node }">
            <p>{{ node.label }}</p>
          </template>

          <template #url="{ node }">
            <a class="pl-1" :href="node.to">{{ node.label }}</a>
          </template>
        </Tree>
      </AccordionContent>
    </AccordionPanel>
  </Accordion>
</template>

<script setup>
import Accordion from 'primevue/accordion'
import AccordionPanel from 'primevue/accordionpanel'
import AccordionHeader from 'primevue/accordionheader'
import AccordionContent from 'primevue/accordioncontent'
import Tree from 'primevue/tree'

const menus = [
  {
    key: '0',
    header: 'ダッシュボード',
    icon: 'pi-table',
    to: '/admin/',
    type: 'url'
  },
  {
    key: '1',
    header: 'ホームページ構成',
    icon: 'pi-file',
    contents: [
      {
        key: '0',
        label: 'ページ',
        children: [
          {
            key: '0-0',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/pages/templates',
            type: 'url'
          },
          {
            key: '0-1',
            label: '一覧（編集・削除）',
            icon: 'pi-list',
            to: '/admin/pages',
            type: 'url'
          }
        ]
      },
      {
        key: '1',
        label: 'テンプレート',
        children: [
          {
            key: '1-0',
            label: '一覧（編集・削除）',
            icon: 'pi-list',
            to: '/admin/templates',
            type: 'url'
          }
        ]
      },
      {
        key: '3',
        label: '共通フッター',
        to: '/admin/footer',
        type: 'url'
      }
    ]
  },
  {
    key: '2',
    header: 'パーツ',
    icon: 'pi-box',
    contents: [
      {
        key: '0',
        label: '企業・店舗情報',
        children: [
          {
            key: '0-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/shop_item',
            type: 'url'
          },
          {
            key: '0-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/shop_item/create',
            type: 'url'
          }
        ]
      },
      {
        key: '1',
        label: 'メニュー',
        children: [
          {
            key: '1-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/menu_item',
            type: 'url'
          },
          {
            key: '1-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/menu_item/create',
            type: 'url'
          },
          {
            key: '1-2',
            label: 'カテゴリー',
            icon: 'pi-folder',
            to: '/admin/menu_category',
            type: 'url'
          }
        ]
      },
      {
        key: '2',
        label: 'ギャラリー',
        children: [
          {
            key: '2-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/gallery_item',
            type: 'url'
          },
          {
            key: '2-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/gallery_item/create',
            type: 'url'
          },
          {
            key: '2-2',
            label: 'カテゴリー',
            icon: 'pi-folder',
            to: '/admin/gallery_category',
            type: 'url'
          },
          {
            key: '2-3',
            label: '設定',
            icon: 'pi-cog',
            to: '/admin/gallery_setting',
            type: 'url'
          }
        ]
      },
      {
        key: '3',
        label: 'スタッフ',
        children: [
          {
            key: '3-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/staff_member',
            type: 'url'
          },
          {
            key: '3-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/staff_member/create',
            type: 'url'
          },
          {
            key: '3-2',
            label: '部署・役職',
            icon: 'pi-folder',
            to: '/admin/department',
            type: 'url'
          }
        ]
      },
      {
        key: '4',
        label: 'よくある質問',
        children: [
          {
            key: '4-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/faq_item',
            type: 'url'
          },
          {
            key: '4-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/faq_item/create',
            type: 'url'
          },
          {
            key: '4-2',
            label: 'カテゴリー',
            icon: 'pi-folder',
            to: '/admin/faq_category',
            type: 'url'
          }
        ]
      },
      {
        key: '5',
        label: 'ビフォーアフター',
        children: [
          {
            key: '5-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/before_after_item',
            type: 'url'
          },
          {
            key: '5-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/before_after_item/create',
            type: 'url'
          },
          {
            key: '5-2',
            label: 'カテゴリー',
            icon: 'pi-folder',
            to: '/admin/before_after_category',
            type: 'url'
          },
          {
            key: '5-3',
            label: '設定',
            icon: 'pi-cog',
            to: '/admin/before_after_setting',
            type: 'url'
          }
        ]
      },
      {
        key: '7',
        label: 'リクルート',
        children: [
          {
            key: '7-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/recruiting',
            type: 'url'
          },
          {
            key: '7-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/recruiting/create',
            type: 'url'
          },
          {
            key: '7-2',
            label: 'カテゴリー',
            icon: 'pi-folder',
            to: '/admin/recruiting_category',
            type: 'url'
          },
          {
            key: '7-3',
            label: '設定',
            icon: 'pi-cog',
            to: '/admin/recruiting_setting',
            type: 'url'
          }
        ]
      },
      {
        key: '8',
        label: 'お問い合わせ',
        children: [
          {
            key: '8-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/inquiry_form',
            type: 'url'
          },
          {
            key: '8-1',
            label: '新規追加',
            icon: 'pi-plus',
            to: '/admin/inquiry_form/create',
            type: 'url'
          },
        ]
      },
      {
        key: '9',
        label: 'お気に入り',
        children: [
          {
            key: '9-0',
            label: '一覧',
            icon: 'pi-list',
            to: '/admin/favorite',
          }
        ]
      },
    ]
  },
  {
    key: '3',
    header: '新着情報',
    icon: 'pi-megaphone',
    contents: [
      {
        key: '0-0',
        label: '投稿一覧',
        to: '/admin/news_articles',
        type: 'url'
      },
      {
        key: '0-1',
        label: '新規作成',
        to: '/admin/news_articles/add',
        type: 'url'
      },
      {
        key: '0-2',
        label: 'カテゴリー',
        to: '/admin/news_categories',
        type: 'url'
      },
      {
        key: '0-3',
        label: '設定',
        to: '/admin/news_articles/basic_setting',
        type: 'url'
      }
    ]
  },
  {
    key: '4',
    header: 'ブログ',
    icon: 'pi-pencil',
    contents: [
      {
        key: '0-0',
        label: '投稿一覧',
        to: '/admin/blogs_posts',
        type: 'url'
      },
      {
        key: '0-1',
        label: '新規作成',
        to: '/admin/blogs_posts/add',
        type: 'url'
      },
      {
        key: '0-2',
        label: '新規作成 (かんたんブログ)',
        to: '/admin/blogs_posts/blogs_simple',
        type: 'url'
      },
      {
        key: '0-3',
        label: 'テンプレートから新規追加',
        to: '/admin/blogs_templates',
        type: 'url'
      },
      {
        key: '0-4',
        label: 'カテゴリー',
        to: '/admin/blogs_categories',
        type: 'url'
      },
      {
        key: '0-5',
        label: '設定',
        to: '/admin/blogs_posts/basic_setting',
        type: 'url'
      }
    ]
  },
  {
    key: '5',
    header: '画像・動画・文書ファイル',
    icon: 'pi-file',
    contents: [
      {
        key: '0',
        label: '画像',
        children: [
          {
            key: '0-0',
            label: '一覧',
            to: '/admin/images',
            type: 'url'
          },
          {
            key: '0-1',
            label: '新規追加',
            to: '/admin/images/add',
            type: 'url'
          },
          {
            key: '0-2',
            label: 'カテゴリー',
            to: '/admin/image_categories',
            type: 'url'
          }
        ]
      },
      {
        key: '1',
        label: '動画',
        children: [
          {
            key: '1-0',
            label: '一覧',
            to: '/admin/videos',
            type: 'url'
          },
          {
            key: '1-1',
            label: '新規追加',
            to: '/admin/videos/add',
            type: 'url'
          },
          {
            key: '1-2',
            label: 'カテゴリー',
            to: '/admin/video_categories',
            type: 'url'
          }
        ]
      },
      {
        key: '2',
        label: '文書ファイル',
        children: [
          {
            key: '2-1',
            label: '一覧',
            to: '/admin/document_files',
            type: 'url'
          },
          {
            key: '2-1',
            label: '新規追加',
            to: '/admin/document_files/add',
            type: 'url'
          }
        ]
      }
    ]
  },
  {
    key: '6',
    header: 'レポート',
    icon: 'pi-chart-bar',
    contents: [
      {
        key: '0-0',
        label: '更新履歴',
        to: '/admin/change_logs',
        type: 'url'
      }
    ]
  },
  {
    key: '8',
    header: '設定',
    icon: 'pi-wrench',
    contents: [
      {
        key: '0-0',
        label: '基本設定',
        to: '/admin/setting/general',
        type: 'url'
      },
      {
        key: '0-1',
        label: '初期設定',
        to: '/admin/setting/initial',
        type: 'url'
      },
      {
        key: '0-2',
        label: '共通外観設定',
        to: '/admin/setting/appearance',
        type: 'url'
      },
      {
        key: '7',
        label: 'ユーザー',
        to: '/admin/user',
        type: 'url'
      },
      {
        key: '1',
        label: 'ヘッダー・フッター',
        to: '/admin/settings/header-footer',
        type: 'url'
      },
      {
        key: '2',
        label: 'サイドバナー',
        to: '/admin/sidenavi',
        type: 'url'
      },
      {
        key: '1',
        label: 'SNS設定',
        to: '/admin/settings/sns',
        type: 'url'
      },
      {
        key: '1',
        label: 'ペイメント関連',
        to: '/admin/settings/payment',
        type: 'url'
      },
      {
        key: '1',
        label: 'タグ',
        to: '/admin/tags',
        type: 'url'
      },
      {
        key: '1',
        label: 'サイトマップ',
        to: '/admin/settings/site-map',
        type: 'url'
      },
      {
        key: '1',
        label: '埋め込みスクリプト',
        to: '/admin/settings/embedded-script',
        type: 'url'
      },
      {
        key: '1',
        label: 'リダイレクト設定',
        to: '/admin/redirects',
        type: 'url'
      },
      {
        key: '1',
        label: '拡張設定',
        children: [
          {
            key: '0-0',
            label: '独自CSS',
            to: '/admin/settings/css',
            type: 'url'
          },
          {
            key: '0-1',
            label: '独自JS',
            to: '/admin/settings/js',
            type: 'url'
          }
        ]
      },
      {
          key: '1',
          label: '高度な設定',
          to: '/admin/settings/advanced',
          type: 'url'
      },
        {
            key: '2',
            label: 'サブナビゲーション',
            children: [
                {
                    key: '0-0',
                    label: '一覧',
                    to: '/admin/navigations',
                    type: 'url'
                },
                {
                    key: '0-1',
                    label: '新規追加',
                    to: '/admin/navigations/add',
                    type: 'url'
                }
            ]
        },
    ]
  }
]

const open = menu => {
  if (!menu.contents && menu.to) {
    location.href = menu.to
  }
}
</script>
