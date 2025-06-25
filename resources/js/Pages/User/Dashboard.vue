<script setup>
import { computed } from "vue"

import moment from "moment"
import { FreeMode } from "swiper/modules"
import {
  Swiper,
  SwiperSlide,
} from "swiper/vue"

import ContentCreateModal from "@/Components/User/ContentCreateModal.vue"
import CreatePostCard from "@/Components/User/CreatePostCard.vue"
import PostCard from "@/Components/User/PostCard.vue"
import sharedComposable from "@/Composables/sharedComposable"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import UserLayout from "@/Layouts/User/UserLayout.vue"
import { useModalStore } from "@/Store/modalStore"
import { router } from "@inertiajs/vue3"
import trans from "@/Composables/transComposable"
defineOptions({ layout: UserLayout })
const props = defineProps([
  'contents',
  'schedulePosts',
  'brands',
  'user',
  'totalBrands',
  'totalPosts',
  'totalReactions',
  'totalComments',
  'totalStorage',
  'socialAccounts',
  'totalCredits'
])

const { textExcerpt } = sharedComposable()
const modal = useModalStore()
const primaryOverview = computed(() => {
  return [
    {
      title: trans('Total Brands'),
      value: props.totalBrands,
      url: '#',
      icon: 'bx bx-box',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: trans('Total Post'),
      value: props.totalPosts,
      url: '#',
      icon: 'bx bx-receipt',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: trans('Storage Used'),
      value: props?.totalStorage + ' MB',
      url: '#',
      icon: 'bx bx-memory-card',
      classes: 'text-warning-500 bg-warning-500'
    },
    {
      title: trans('Social Accounts'),
      value: props.socialAccounts,
      url: '#',
      icon: 'bx bx-group',
      classes: 'text-info-500 bg-info-500'
    },
    {
      title: trans('Reactions'),
      value: props.totalReactions,
      url: '#',
      icon: 'bx bx-like',
      classes: 'text-sky-500 bg-sky-500'
    },
    {
      title: trans('Comments'),
      value: props.totalComments,
      url: '#',
      icon: 'bx bx-comment-detail',
      classes: 'text-lime-500 bg-lime-500'
    }
  ]
})

const isNearExpiry = computed(() => {
  if (props.user.will_expire) {
    const userWillExpireDate = moment(props.user.will_expire)
    const daysDifference = userWillExpireDate.diff(moment(), 'days')
    return daysDifference < 7
  }
  return false
})
const hasExpired = computed(() => {
  if (props.user.will_expire) {
    const userWillExpireDate = moment(props.user.will_expire)
    return userWillExpireDate.isBefore(moment())
  }
  return false
})

// generate current week days for calendar
const currentWeekDays = computed(() => {
  const days = []
  const today = new Date()
  for (let i = 0; i < 7; i++) {
    days.push(moment(today).add(i, 'days').format('D'))
  }
  return days
})
</script>

<template>
  <ContentCreateModal :brands="brands" />

  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Dashboard')" />
    <div class="mb-3">
      <div class="alert alert-danger flex items-center text-base"
        v-if="!user.will_expire || !user.plan || !user.plan_id">
        <span>{{ trans("You haven't purchased any subscription plans yet.") }}</span>
        <Link class="text-sm font-semibold underline" :href="route('user.subscription.index')">
        {{ trans('Purchase Now') }}
        </Link>
      </div>
      <div class="alert alert-danger flex items-center text-base" v-if="hasExpired">
        <p>{{ trans('Your subscription has already expired') }}</p>
        <Link class="text-sm font-semibold underline" :href="route('user.subscription.payment', user.plan_id)">
        {{ trans('Renew Now') }}
        </Link>
      </div>
      <div class="alert alert-warning flex items-center text-base" v-else-if="isNearExpiry">
        <p>
          {{ trans('Your current subscription plan is about to expire in less than 7 days') }}
        </p>
        <Link class="text-sm font-semibold underline" :href="route('user.subscription.index')">
        {{ trans('Renew Now') }}
        </Link>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
      <div class="col-span-1 lg:col-span-8">
        <section class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">
          <!-- primary Overview -->
          <template v-for="(item, index) in primaryOverview" :key="index">
            <Link :href="item.url">
            <div class="card rounded-2xl">
              <div class="flex items-center gap-3 p-5">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-opacity-10"
                  :class="item.classes">
                  <i class="text-2xl" :class="item.icon"></i>
                </div>
                <div class="flex flex-1 flex-col">
                  <p class="text-sm tracking-wide text-slate-500">
                    {{ trans(item.title) }}
                  </p>
                  <h5>{{ item.value }}</h5>
                </div>
              </div>
            </div>
            </Link>
          </template>
        </section>

        <!-- Drafts -->
        <div class="card mt-8 pb-2">
          <div class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700">
            <div class="flex items-center">
              <div
                class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-400 bg-opacity-10 text-emerald-500">
                <i class="bx bx-file text-2xl"></i>
              </div>
              <h5 class="mr-1">{{ trans('Posts') }}</h5>
            </div>

            <button v-if="brands?.length > 0" type="button" @click="modal.open('createContent')">
              <i class="bx bx-plus text-2xl"></i>
            </button>

            <Link v-else type="button" :href="route('user.brand.create')">
            <i class="bx bx-plus text-2xl"></i>
            </Link>
          </div>
          <!-- cards -->
          <div class="styled-scrollbar flex w-full gap-6 overflow-x-auto px-6 pb-5">
            <Swiper :space-between="30" :slidesPerView="'auto'" :grabCursor="true">
              <SwiperSlide class="w-[18rem]">
                <CreatePostCard v-if="brands?.length > 0" @action="modal.open('createContent')" />
                <CreatePostCard v-else @action="router.get(route('user.brand.create'))" text="Create Brand" />
              </SwiperSlide>
              <SwiperSlide v-for="content in contents" :key="content.id" class="w-[18rem]">
                <PostCard :content="content" />
              </SwiperSlide>
            </Swiper>
          </div>
        </div>
      </div>
      <!-- right side -->
      <div class="col-span-1 lg:col-span-4">
        <div class="card rounded-b-none rounded-t-2xl">
          <div class="flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700">
            <div class="flex items-center">
              <div
                class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-400 bg-opacity-10 text-emerald-500">
                <Icon icon="bx:calendar-event" class="text-2xl" />
              </div>
              <div>
                <p class="mr-1 text-sm font-semibold lg:text-lg">
                  {{ moment().format('ddd, MMMM') }}
                </p>
                <p class="text-sm text-gray-400">{{ moment().format('YYYY') }}</p>
              </div>
            </div>

            <Link class="ml-2 rounded-lg border px-2 py-2 hover:bg-slate-100 dark:hover:bg-dark-900"
              :href="route('user.brand-posts.index')">
            <Icon icon="bx:chevron-right" class="text-2xl" />
            </Link>
          </div>
          <div class="m-4 flex justify-around">
            <div v-for="item in currentWeekDays" :key="item" class="flex flex-col items-center justify-center">
              <!-- if day is today -->
              <p class="my-2 h-10 w-10 rounded-full p-2 text-center" :class="{
                'border border-green-600 text-green-600': moment().format('D') === item
              }">
                {{ item }}
              </p>
            </div>
          </div>
        </div>

        <!-- scheduled posts -->
        <div class="card mt-3 rounded-b-2xl rounded-t-none">
          <div class="card-body">
            <div v-if="schedulePosts.length > 0">
              <div v-for="post in schedulePosts" :key="post.id"
                class="flex items-center gap-2 rounded-md bg-slate-100 p-3 dark:bg-slate-700">
                <img :src="post?.media?.[0] ?? '/assets/images/no-photo-available.png'"
                  @error="(e) => (e.target.src = '/assets/images/no-photo-available.png')" class="max-w-20 rounded" />
                <div>
                  <p>{{ textExcerpt(post.title, 30) }}</p>
                  <p>
                    {{ trans('Date:') }}
                    {{ moment(post.scheduled_at).format('DD MMM | h:mm A') }}
                  </p>
                  <p>
                    {{ trans('Status:') }}
                    <span class="badge capitalize" :class="{
                      'badge-success': ['schedule', 'scheduled'].includes(post.status)
                    }">{{ post.status }}</span>
                  </p>
                </div>
              </div>
            </div>
            <p v-else>{{ trans('You do not have scheduled posts yet.') }}</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
