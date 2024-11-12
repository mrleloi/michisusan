import _ky from 'ky'
import { pagesAPI } from './pages'
import { listAPI } from './list'
import { categorySelectorAPI } from './category_selector'
import { imageSelectorAPI } from './image_selector'
import { newsArticlesAPI } from './news-articles'
import { newsCategoriesAPI } from './news-categories'
import { blogsPostsAPI } from './blogs-posts'
import { blogsCategoriesAPI } from './blogs-categories.js'
import { translateAPI } from './translate'
import { tagsAPI } from './tags.js'
import { sendmailAPI } from './sendmail.js'
import { beforeAfterPartsAPI } from './parts/before_after.js'
import { menuPartsAPI } from './parts/menu.js'
import { staffMemberPartsAPI } from './parts/staff-member.js'
import { galleryPartsAPI } from './parts/gallery.js'
import { shopPartsAPI } from './parts/shop.js'
import { faqPartsAPI } from './parts/faq.js'
import { recruitingPartsAPI } from './parts/recruiting.js'

export const useAPI = (options = {}) => {
  const tokenMatch = document.cookie.match(
    // TODO: sanctrumで可能なら後々排除する
    new RegExp('(^| )XSRF-TOKEN=([^;]+)')
  )
  const jwtAuth = localStorage.getItem('jwtAuth') ?? ''
  const ky = _ky.create({
    prefixUrl: '/api',
    headers: {
      'content-type': 'application/json',
      'X-XSRF-TOKEN':
        tokenMatch.length > 1 ? decodeURIComponent(tokenMatch[2]) : ''
    },
    ...options
  })

  return {
    pages: pagesAPI(ky),
    list: listAPI(ky),
    categorySelector: categorySelectorAPI(ky),
    imageSelector: imageSelectorAPI(ky),
    newsArticles: newsArticlesAPI(ky),
    newsCategories: newsCategoriesAPI(ky),
    blogsPosts: blogsPostsAPI(ky),
    blogsCategories: blogsCategoriesAPI(ky),
    translate: translateAPI(ky),
    tags: tagsAPI(ky),
    sendmail: sendmailAPI(ky),
    beforeAfterParts: beforeAfterPartsAPI(ky),
    menuParts: menuPartsAPI(ky),
    staffMemberParts: staffMemberPartsAPI(ky),
    galleryParts: galleryPartsAPI(ky),
    shopParts: shopPartsAPI(ky),
    faqParts: faqPartsAPI(ky),
    recruitingParts: recruitingPartsAPI(ky)
  }
}
