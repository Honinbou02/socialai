<script setup>
import { onMounted, onUpdated, defineAsyncComponent } from 'vue'
import dropdown from '@/Plugins/Admin/dropdown'

const Sidebar = defineAsyncComponent(() => import('@/Layouts/Admin/Sidebar.vue'))
const Header = defineAsyncComponent(() => import('@/Layouts/Admin/Header.vue'))
const ValidationErrors = defineAsyncComponent(() =>
  import('@/Components/Admin/ValidationErrors.vue')
)
const ToastrContainer = defineAsyncComponent(() => import('@/Components/ToastrContainer.vue'))
const ActionModal = defineAsyncComponent(() => import('@/Components/Admin/ActionModal.vue'))

onMounted(() => dropdown.init())

onUpdated(() => dropdown.init())
</script>

<template>
  <ToastrContainer />

  <ActionModal />
  <Sidebar />
  <div class="wrapper">
    <Header />
    <ValidationErrors />
    <div class="content">
      <slot></slot>
    </div>
  </div>
</template>
