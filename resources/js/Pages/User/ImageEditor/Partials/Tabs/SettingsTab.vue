<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
import { ref } from 'vue'
const store = useDesignStore()
defineProps(['categories'])
const category = ref(store.form.title || '')
const status = ref(store.form.status || '')
const save = () => {
  store.$patch({
    form: { title: category.value, status: status.value }
  })
}
</script>
<template>
  <h3>{{ trans('Settings') }}</h3>

  <div class="mt-4 space-y-4">
    <button
      @click="
        () => {
          store.canvasStyles.backgroundColor = 'transparent'
          store.changeCanvasStyle()
        }
      "
      class="btn btn-soft-success block w-full"
    >
      {{ trans('Remove Background') }}
    </button>
    <div class="flex items-center justify-between gap-2">
      <span class="text-lg">{{ trans('BG Color') }} </span>

      <div class="flex items-center gap-3">
        <div class="h-10 w-10 overflow-hidden rounded-full">
          <input
            v-model="store.canvasStyles.backgroundColor"
            @input="store.changeCanvasStyle"
            class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
            type="color"
            name="file"
          />
        </div>
        <p class="w-16">
          {{ store.canvasStyles.backgroundColor }}
        </p>
      </div>
    </div>
  </div>
</template>
