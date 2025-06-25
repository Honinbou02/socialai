<script setup>
import { defineAsyncComponent, onMounted, onUpdated } from 'vue'

import feather from 'feather-icons'
import ResizeObserver from 'resize-observer-polyfill'

import dropdown from '@/Plugins/Admin/dropdown'

const Sidebar = defineAsyncComponent(() => import('@/Layouts/Admin/Sidebar.vue'))
const Header = defineAsyncComponent(() => import('@/Layouts/Admin/Header.vue'))
const ValidationErrors = defineAsyncComponent(() =>
  import('@/Components/Admin/ValidationErrors.vue')
)
const ActionModal = defineAsyncComponent(() => import('@/Components/Admin/ActionModal.vue'))
const ToastrContainer = defineAsyncComponent(() => import('@/Components/ToastrContainer.vue'))
//Third party packages
onMounted(() => {
  dropdown.init()
  feather.replace()
  window.ResizeObserver = ResizeObserver
})

onUpdated(() => {
  dropdown.init()
  feather.replace()
})
</script>

<template>
  <div>
    <ToastrContainer />
    <ActionModal />
    <Sidebar panel="user" />
    <div class="wrapper">
      <Header panel="user" />
      <ValidationErrors />

      <div class="content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
