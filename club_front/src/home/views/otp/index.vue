<template>
  <div class="flex  justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">ورود با شماره تلفن</h2>
      <div class="mb-4">
        <label class="form-label text-gray-700 font-medium">شماره تلفن:</label>
        <input
          v-model="phoneNumber"
          type="tel"
          placeholder="مثال: 09123456789"
          :disabled="isCodeSent"
          class="form-control px-3 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-blue-300 transition w-full"
        />
        <button
          @click="sendVerificationCode"
          v-if="!isCodeSent"
          class="btn btn-primary w-full mt-3 py-2 rounded-lg"
        >
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
        >
          تأیید کد
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { $ref } from 'unplugin-vue-macros/macros';
import axios from "axios";
let phoneNumber = $ref('');
let verificationCode = $ref('');
let isCodeSent = $ref(false);

const customAxios = axios.create({
  // baseURL: 'http://localhost:5000/',
  baseURL: 'https://holoosmart.ir/'
});
const sendVerificationCode = async () => {
  if (!phoneNumber) {
    alert('لطفاً شماره تلفن خود را وارد کنید.');
    return;
  }
  const data = {
    username: phoneNumber,
    method: "login",
    country_code: "IR"
  };
  axios.post('https://holoo.bizups.ai/api/iam/auth/otp', data, {
    headers: {
      'Accept': 'application/json',
      'Accept-Language': 'en',
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      console.log('Response:', response.data);
      isCodeSent = true;
    })
    .catch(error => {
      isCodeSent = false;
      console.error('Error:', error);
    });


};
const verifyCode = async () => {
  if (!verificationCode) {
    alert('لطفاً کد تأیید را وارد کنید.');
    return;
  }
  console.log(`بررسی کد: ${verificationCode} برای شماره: ${phoneNumber}`);
  alert('ورود موفقیت‌آمیز بود!');
};
</script>
<style scoped>
input::placeholder{
  text-align: right;
}
</style>
