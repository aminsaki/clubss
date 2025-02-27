<template>
  <div class="text-end">

    <h1 class="p-3 text-lg  text-center  text-rose-500">تمدید پشتیبانی آنلاین هلو</h1>

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

    <div class="mb-4">
      <h5 class="text-center text-lg p-3 ">خلاصه پرداخت</h5>

      <ul class="list-group" v-if="props?.price?.article">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <h6 style="direction: rtl">
            <span
              class="text-red-900 text-lg">{{ numberFormats(props?.price?.article[0]?.price) }}</span>
            ریال
          </h6>
          <span class="text-teal-600">{{ props?.price?.article[0]?.title }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <h6 style="direction: rtl">
            <span class="text-red-900 text-lg">{{ numberFormats(props.price?.maliyat) }}</span> ریال
          </h6>
          <span class="text-teal-600">مالیات</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <h6 style="direction: rtl">
            <span class="text-red-900 text-lg">{{ numberFormats(props.price.totalprice) }}</span>
            ریال
          </h6>
          <span class="text-teal-600">جمع کل</span>
        </li>
      </ul>
    </div>
    <div class="d-grid gap-2">
      <button v-if="status" type="button"
              class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
              @click="btn_payment()">پرداخت
      </button>
      <button v-else
              class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
        <span class="spinner-grow fo spinner-grow-sm"><span class="sr-only">  </span></span>
      </button>
    </div>
  </div>
</template>
<script setup>
import {$ref} from "unplugin-vue-macros/macros";
import {converDatePersian} from "@/commons/helpers/DatePersian.js";
import {numberFormats} from "@/commons/helpers/Number.js"
import toast from "bootstrap/js/src/toast.js";
import {myErrors} from "@/commons/helpers/errors.js";
import webUrls from "../../../../config/dev.json";

const props = defineProps({
  data: Object,
  price: Object
});
let status = $ref(true);

async function btn_payment() {
  status = false;
   let price = props.price.totalprice;
    let mobile = props.data.partyMobile;
  if (price < 0 || price === "") {
    toast.success("مبلغ پرداخت باید بیشتر از 1000 تومان باشد");
    return true;
  }
   status = 'true';
  try {
    window.location.href =`https://clubs.holootech.ir/api/v1/payments/pay?uid=${price}&mobile=${mobile}&serial_number=${props.data.serial}`;
    return false;
  } catch (error) {
    status = false;
    myErrors(error);
  }
}

</script>
