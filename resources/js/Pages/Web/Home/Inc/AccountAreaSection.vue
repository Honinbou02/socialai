<script lang="ts" setup>
import trans from "@/Composables/transComposable"

const props = defineProps({
  data: {
    type: Object,
    default: {},
  },
})
</script>

<template>
  <div class="tp-account-area pb-120">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6 col-lg-6">
          <div
            class="text-center tp-account-thumb-wrapper p-relative wow tpfadeLeft"
            data-wow-duration=".9s"
            data-wow-delay=".5s"
          >
            <div class="tp-account-bg">
              <img :src="data.img1" alt="" />
            </div>
            <div class="tp-account-main-img">
              <img :src="data.img2" alt="" />
            </div>
            <div class="tp-account-author">
              <img :src="data.img3" alt="" />
            </div>
            <div class="tp-account-shape-1">
              <img :src="data.img4" alt="" />
            </div>
            <div class="tp-account-shape-2">
              <img :src="data.img5" alt="" />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="tp-account-step-wrapper">
            <div class="mb-40 tp-account-section-box">
              <h4 class="tp-section-subtitle-2">{{ data.title }}</h4>
              <h3 class="tp-section-title-lg">{{ data.sub_title }}</h3>
            </div>
            <div class="tp-account-step mb-50">
              <div
                v-for="(item, index) in data.steps?.split(',')"
                :key="index"
                class="tp-account-item d-flex align-items-center"
              >
                <span>{{ index + 1 }}</span>
                <p>{{ item }}</p>
              </div>
            </div>
            <div class="tp-account-btn-box">
              <a class="tp-btn-green mb-15" :href="data.btn_link"> {{ data.btn_text }}</a>
              <p>{{ data.bottom_text }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
