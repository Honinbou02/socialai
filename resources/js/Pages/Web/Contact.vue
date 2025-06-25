<script setup>
import InputFieldError from '@/Components/InputFieldError.vue'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: DefaultLayout })

defineProps(['contact'])

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submit = () => {
  form.post('/contact-us', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    }
  })
}
</script>

<template>
  <!-- tp-breadcrumb-area-start -->
  <div class="about-banner-area p-relative">
    <div class="about-shape-1 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="about-shape-2 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="about-banner p-relative z-index fix">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="about-banner-content">
              <h4
                class="about-banner-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="contact.page_title"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-area-end -->

  <!-- tp-breadcrumb-header-area-start -->
  <div class="about-img-area mb-100 z-index-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div
            class="about-img about-img-height p-relative"
            :style="{ backgroundImage: `url(${contact.image})` }"
          >
            <div class="about-img-content">
              <h4
                class="about-img-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="contact.page_title"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-header-area-end -->

  <!-- tp-contact-area-strat -->
  <div class="contact-info-area pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item">
            <div class="contact-info-img">
              <img :src="contact.office_left_img" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_left_name }}</a>
              </h5>
              <p>
                {{ contact.office_left_address }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item p-relative">
            <div class="contact-info-badge">
              <span>{{ trans('Main Office') }}</span>
            </div>
            <div class="contact-info-img">
              <img :src="contact.office_center_img" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_center_name }}</a>
              </h5>
              <p>
                <a href="#">{{ contact.office_center_address }}</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item">
            <div class="contact-info-img">
              <img :src="contact.office_right_img" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_right_name }}</a>
              </h5>
              <p>
                <a href="#">{{ contact.office_right_address }}</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-form-area pb-120">
    <div class="container">
      <div class="row gx-0">
        <div class="col-xl-5 col-lg-6">
          <div class="contact-form-left">
            <div class="contact-form-section-box pb-10">
              <h5 class="inner-section-subtitle">{{ contact.top_title }}</h5>
              <h4 class="tp-section-title pb-10" v-html="contact.title"></h4>
              <p>
                {{ contact.sub_title }}
              </p>
            </div>
            <div class="contact-form-social-box p-relative">
              <div class="contact-form-social-item">
                <a target="_blank" :href="contact.facebook"><i class="fab fa-facebook-f"></i></a>
                <a target="_blank" :href="contact.twitter"><i class="fab fa-twitter"></i></a>
                <a target="_blank" :href="contact.linkedin"><i class="fab fa-linkedin-in"></i></a>
                <a target="_blank" :href="contact.instagram"><i class="fab fa-instagram"></i></a>
              </div>
              <div class="contact-form-section-img">
                <img :src="contact.left_img" alt="" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-7 col-lg-6">
          <div class="contact-form-right-warp">
            <div class="postbox__comment-form">
              <form @submit.prevent="submit" class="box">
                <div class="row gx-20">
                  <div class="col-12">
                    <div class="postbox__comment-input mb-30">
                      <input type="text" v-model="form.name" class="inputText" />
                      <span class="floating-label">{{ trans('Full Name') }}</span>
                      <InputFieldError :message="form.errors.name" />
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="postbox__comment-input mb-30">
                      <input type="email" v-model="form.email" class="inputText" />
                      <InputFieldError :message="form.errors.email" />
                      <span class="floating-label">{{ trans('Your Email') }}</span>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="postbox__comment-input mb-35">
                      <input type="text" v-model="form.subject" class="inputText" />
                      <InputFieldError :message="form.errors.subject" />
                      <span class="floating-label">{{ trans('Subject') }}</span>
                    </div>
                  </div>

                  <div class="col-xxl-12">
                    <div class="postbox__comment-input mb-30">
                      <textarea v-model="form.message" class="textareaText"></textarea>
                      <InputFieldError :message="form.errors.message" />
                      <span class="floating-label-2">{{ trans('Message...') }}</span>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="postbox__btn-box">
                      <SpinnerBtn
                        :processing="form.processing"
                        :btn-text="trans('Send your Request')"
                        class="submit-btn w-100"
                      />
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-inner-area pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="contact-inner-title-sm-wrap mb-50 text-center">
            <h4 class="contact-inner-title-sm">{{ contact.bottom_title }}</h4>
            <p>{{ contact.bottom_sub_title }}</p>
          </div>
        </div>
      </div>
      <div class="d-flex contact-inner-wrapper justify-content-center px-0">
        <div class="row gx-0 info-container">
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-1">
                <img :src="contact.bottom_email_img" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="`mailto:${contact.email}`">{{ contact.email }}</a>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-2">
                <img :src="contact.bottom_phone_img" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="`tel:${contact.phone}`">{{ contact.phone }}</a>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-3">
                <img :src="contact.bottom_address_img" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="contact?.map_link ?? '#'" target="_blank">{{ contact.address }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-contact-area-end -->
</template>
