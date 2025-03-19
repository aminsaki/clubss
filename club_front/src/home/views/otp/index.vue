<template>
  <div class="flex justify-center items-center min-h-screen">
    <successful v-if="statusOtp === 'SUCCESSFUL'" ></successful>
    <div  v-else class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">ورود با شماره تلفن</h2>
      <p class="text-gray-600 text-center mb-3">برای اتمام خرید لطفا شماره تلفن خود را وارد کنید.</p>
      <div class="mb-4">
        <label class="form-label text-gray-700 font-medium">شماره تلفن:</label>
        <input
          v-model="phoneNumber"
          type="tel"
          maxlength="13"
          minlength="10"
          placeholder="مثال: +989904289707"
          :disabled="isCodeSent || loading"
          class="form-control px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-blue-300 transition w-full"
          @input="formatPhoneNumber"
        />
        <p class="text-sm text-gray-500 mt-1">شماره تلفن شما به صورت خودکار به فرمت بین‌المللی تبدیل می‌شود (+98).</p>
        <button
          @click="sendVerificationCode"
          v-if="!isCodeSent"
          class="btn btn-primary w-full mt-3 py-2 rounded-lg"
          :disabled="loading || phoneError"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm"></span>
          ارسال کد تأیید
        </button>
      </div>
      <div v-if="isCodeSent" class="mb-4">
        <label class="form-label text-gray-700 font-medium">کد تأیید:</label>
        <input
          v-model="verificationCode"
          type="text"
          placeholder="کد دریافتی را وارد کنید"
          class="form-control px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-green-300 transition w-full"
        />
        <button
          @click="verifyCode"
          class="btn btn-success w-full mt-3 py-2 rounded-lg"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm"></span>
          تأیید کد
        </button>
      </div>
    </div>
  </div>

</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import Successful from "@/home/views/otp/successful.vue";
const phoneNumber = ref('');
const verificationCode = ref('');
const isCodeSent = ref(false);
const loading = ref(false);
const phoneError = ref(false);
const statusOtp = ref('PERSONAL');
const customAxios = axios.create({
  baseURL: 'https://club.holoo.co.ir/',
});
//
const formatPhoneNumber = () => {
  phoneNumber.value = phoneNumber.value.replace(/^0/, '+98');
  phoneError.value = !/^\+98\d{10}$/.test(phoneNumber.value);
};

const sendVerificationCode = async () => {
  if (!phoneNumber.value || phoneError.value) {
    Swal.fire({ icon: 'error',  confirmButtonText: 'متوجه شدم' , title: 'خطا', text: 'شماره تلفن نامعتبر است. لطفاً فرمت صحیح را رعایت کنید.' });
    return;
  }
  loading.value = true;
  try {
    await customAxios.post('api/iam/auth/otp', {
      username: phoneNumber.value,
      method: 'signup',
      country_code: 'IR',
    }, { headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' } });
    isCodeSent.value = true;
  } catch (error) {
    Swal.fire({ icon: 'error', confirmButtonText: 'متوجه شدم' , title: 'خطا', text: 'ارسال کد ناموفق بود. لطفا دوباره امتحان کنید.' });
  } finally {
    loading.value = false;
  }
};
//
const verifyCode = async () => {
  if (!verificationCode.value) {
    Swal.fire({ icon: 'error',  confirmButtonText: 'متوجه شدم' , title: 'خطا', text: 'لطفاً کد تأیید را وارد کنید.' });
    return;
  }
  loading.value = true;
  try {
    const response = await customAxios.post('api/iam/auth/register/otp', {
      username: phoneNumber.value,
      method: 'signup',
      country_code: 'IR',
      otp_code: verificationCode.value,
      user_type: 'PERSONAL',
    }, { headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' } });
    if (response.status === 201) {
       statusOtp.value = 'SUCCESSFUL';
    } else {
      Swal.fire({ icon: 'error', confirmButtonText: 'متوجه شدم' , title: 'خطا', text: 'کد تایید نامعتبر است.' });
    }
  } catch (error) {
    Swal.fire({ icon: 'error', confirmButtonText: 'متوجه شدم' , title: 'خطا', text: 'مشکلی در تایید کد به وجود آمد. لطفاً دوباره تلاش کنید.' });
  } finally {
    loading.value = false;
  }
};
</script>

