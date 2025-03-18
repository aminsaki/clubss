<template>
  <div class="flex  justify-center">
    <div class="d-flex flex-column card col-md-5 p-2 " v-if="statusOtp === 'SUCCESSFUL'">
      <table class="table table-striped  resultPaymets  " style="direction: rtl; ">
        <thead>
        <tr style="text-align: center" >
          <th colspan="2"  >
            <i class="fa fa-check-circle fs-1 text-green-600 "></i>
            <h5 class="text-green-600 p-3">تراکنش با موفقیت انجام شده</h5>
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="ref_id">
          <td class="p-3"><i class="fa fa-receipt text-rose-500  "></i> کد رهگیری</td>
          <td class="p-3">{{ ref_id }}</td>
        </tr>
        <tr v-if="date ">
          <td class="p-3"><i class="fa fa-calendar-alt text-rose-500 "></i> زمان </td>
          <td class="p-3">{{ dates.converDatePersian(date) }}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md" v-else>
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">ورود با شماره تلفن</h2>
      <div class="mb-4">
        <label class="form-label text-gray-700 font-medium">شماره تلفن:<span class="text-sm text-danger">(لطفا به جا صفر از +98 استفاده کنید)</span> </label>
        <input
          v-model="phoneNumber"
          type="tel"
          maxlength="13"
          minlength="13"
          placeholder="+98900428900"
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
        <button
          @click="RestCode"
          class="btn btn-outline-dark w-full mt-3 py-2 rounded-lg"
        >
          ریست کردن کد
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
import {useRoute} from 'vue-router'
import * as dates from "@/commons/helpers/DatePersian.js";
import {data} from "autoprefixer";


const route = useRoute()
let status = $ref(route.params.params[0]);
let ref_id = $ref((route.params.params[1]) ? route.params.params[1] : 0);
let date = $ref((route.params.params[2]) ? route.params.params[2] : 0);
let statusOtp =  $ref('false');
function MethodState(status) {
  if (status === "SUCCESSFUL") {
    return "SUCCESSFUL";
  }
  return "UNKNOWN";
}
const customAxios = axios.create({
  baseURL: 'https://holoo.bizups.ai/',

});

function RestCode(){
  isCodeSent =  false;
}
const sendVerificationCode = async () => {
  if (!phoneNumber) {
    alert('لطفاً شماره تلفن خود را وارد کنید.');
    return;
  }
  const data = {
    username: phoneNumber,
    method: "signup",
    country_code: "IR"
  };
  customAxios.post('api/iam/auth/otp', data, {
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
  const data = {
    username: phoneNumber,
    method: "signup",
    country_code: "IR",
    otp_code: verificationCode,
    user_type: "PERSONAL",
  };
  customAxios.post('api/iam/auth/register/otp', data, {
    headers: {
      'Accept': 'application/json',
      'Accept-Language': 'en',
      'Content-Type': 'application/json'
    }
  })
    .then(response => {
      if(response.status ===201) {
        statusOtp ='SUCCESSFUL';
        return true
      }else{
        console.log(response);
      }
    })
    .catch(error => {
      isCodeSent = false;
      verificationCode ="";
      alert("متاسفانه کد وارد شده اشتباه می باشد یک بار دیگه امحتان کنید.")
      console.error('Error:', error);
    });
};
</script>
<style scoped>
input::placeholder{
  text-align: right;
}
</style>
