<template>
  <div class="text-end">

    <h1 class="p-3 text-lg  text-center text-cyan-800">تمدید پشتیبانی آنلاین هلو</h1>

    <table class="table table-striped">
      <tbody>
      <tr>
        <td class="text-secondary"> {{ props.data.softwareTitle }}</td>
        <th scope="row">عنوان محصولات</th>
      </tr>
      <tr>
        <td class="text-secondary">{{ props.data.serial }}</td>
        <th scope="row">سریال</th>
      </tr>
      <tr>
        <td class="text-secondary">{{ props.data.partyName }} {{ props.data.partyFamily }}</td>
        <th scope="row"> نام و نام خانوادگی</th>
      </tr>
      <tr>
        <td class="text-secondary">{{ converDatePersian(props.data.guarantyDate) }}</td>
        <th scope="row">تاریخ اعتبار</th>
      </tr>
      <tr>
        <td class="text-secondary">{{ props.data.partyNationalCode }}</td>
        <th>کدملی</th>
      </tr>
      </tbody>
    </table>
    <div class="d-grid gap-2">
     <div v-if="status_btn">

       <button  type="button" v-if="status"
              class=" form-control text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
              @click="getPrices()">تایید اطلاعات
      </button>
      <button v-else
              class="  form-control focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
        <span class="spinner-grow fo spinner-grow-sm"><span class="sr-only">  </span></span>
      </button>
    </div>

     <div v-else>
          <payment  :data="props.data" :price="prices"  ></payment>
     </div>

  </div>
  </div>
</template>
<script setup>
import {$ref} from "unplugin-vue-macros/macros";
import {converDatePersian} from "@/commons/helpers/DatePersian.js";
import  Payment  from "@/home/components/invoice/btn_payment.vue"
import axios from "axios";
import {myErrors} from "@/commons/helpers/errors.js";
import {useRoute} from 'vue-router';
let route = useRoute();
let prices = $ref({});

const props = defineProps({
  data: Object,
  price: Object
});
let status = $ref(true);
let status_btn = $ref(true);
async function getPrices() {
    status = false;
  try {
    const response = await axios.post(`invoices`, {series: route.params.series});
    const res = response.data;
    if (res.status === 'true') {
      status = true;
      status_btn = false;
      prices = res.data;
      console.log(prices);
    }
  } catch (error) {
    status = true;
    myErrors(error);
  }
}

</script>
