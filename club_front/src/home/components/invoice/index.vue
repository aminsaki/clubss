<template>
  <div class="p-1">
    <div v-if="loading" class="d-flex justify-content-center p-3">
      <svg
        class="w-8 h-8 text-gray-800 animate-spin"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 101"
        fill="none"
      >
        <circle
          cx="50"
          cy="50"
          r="40"
          stroke="currentColor"
          stroke-width="4"
          stroke-dasharray="251.2"
          stroke-dashoffset="125.6"
        />
      </svg>
      <span class="text-gray-800 ml-4">در حال انجام بررسی اطلاعات...</span>
    </div>
    <div v-else>
      <div v-if="Object(results).serial">
        <user-information :data="results"></user-information>
      </div>
      <div class="container mt-5 d-flex justify-content-center" v-else>
        <div
          class="alert alert-danger p-5 text-center w-100 rounded-lg shadow-lg d-flex align-items-center"
        >
          <i class="bi bi-exclamation-triangle-fill text-4xl mr-4 text-danger"></i>
          <div class="flex-grow-1">
            <h4 class="font-weight-bold text-xl text-danger mb-3">
              {{
                Object(prices).message
                  ? Object(prices).message
                  : 'متاسفانه کاربر با این شناسه پیدا نشده است'
              }}
            </h4>
            <p class="font-weight-medium text-sm text-dark mb-3">
              مشتری گرامی، در صورت عدم فعال‌سازی تمدید پشتیبانی محصولات تان به دلایل سیستمی و مشکلات
              بانکی (مانند تراکنش ناموفق و …)<br />
              لطفاً چند دقیقه دیگر مجدداً امتحان کنید <br />
              از طریق تلگرام با پشتیبانی به شماره 09045294338 در ارتباط باشید
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from 'axios'
import { myErrors } from '@/commons/helpers/errors.js'
import { useRoute } from 'vue-router'
import { onMounted } from 'vue'
import { $ref } from 'unplugin-vue-macros/macros'
import UserInformation from '@/home/components/invoice/userInformation.vue'

let route = useRoute()
let results = $ref({})
let loading = $ref(true)

async function checkCode() {
  try {
    const response = await axios.get(`invoices/${route.params.series}`)
    const res = response.data
    if (res.status === 'true') {
      results = res.data
      loading = false
      return true
    }
  } catch (error) {
    myErrors(error)
    loading = false
  }
}

onMounted(async () => {
  await checkCode()
})
</script>
