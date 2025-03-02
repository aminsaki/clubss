<template>
  <div class="mb-4">
    <div v-if="props?.price.result === false ">
       <h1 class="d-flex justify-content-center p-2 text-ellipsis text-bold  text-xl  ">{{props.price.message}}</h1>
    </div>

     <div v-else>
       <h5 class="text-center text-lg p-3 ">خلاصه پرداخت</h5>
       <ul class="list-group" v-if="props?.price?.article">
         <li v-for="(item, index) in props.price.article" :key="index" class="list-group-item d-flex justify-content-between align-items-center">
           <h6 style="direction: rtl">
             <span class="text-red-900 text-lg">{{ numberFormats(roundToNearestThousand(item.price)) }}</span>
             ریال
           </h6>
           <span class="text-teal-600">{{ item.title }}</span>
         </li>
         <li class="list-group-item d-flex justify-content-between align-items-center">
           <h6 style="direction: rtl">
             <span class="text-red-900 text-lg">{{ numberFormats(roundToNearestThousand(props.price?.maliyat)) }}</span> ریال
           </h6>
           <span class="text-teal-600">مالیات</span>
         </li>

         <li class="list-group-item d-flex justify-content-between align-items-center">
           <h6 style="direction: rtl">
             <span class="text-red-900 text-lg">{{ numberFormats(roundToNearestThousand(props.price.totalprice)) }}</span>
             ریال
           </h6>
           <span class="text-teal-600">جمع کل</span>
         </li>
       </ul>
     </div>
  </div>
  <div class="d-grid gap-2" v-if="props?.price.result === true ">

    <button v-if="btnSttus" type="button"
            class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
            @click="btn_payment()">پرداخت
    </button>
    <button v-else
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
      <span class="spinner-grow fo spinner-grow-sm"><span class="sr-only">  </span></span>
    </button>
  </div>
</template>

<script setup>
import {numberFormats} from "@/commons/helpers/Number.js";
import toast from "bootstrap/js/src/toast.js";
import {myErrors} from "@/commons/helpers/errors.js";
import axios from "axios";
import {onMounted} from "vue";
import {$ref} from "unplugin-vue-macros/macros";
let btnSttus = $ref(true);

const props = defineProps({
  data: Object,
  price: Object
});

 async function btn_payment() {
  btnSttus = false;
  let price = props.price.totalprice;
  let mobile = props.data.partyMobile;
  if (price < 0 || price === "") {
    toast.success("مبلغ پرداخت باید بیشتر از 1000 تومان باشد");
    return true;
  }
  btnSttus = true;
  try {
      window.location.href =`https://clubs.holootech.ir/api/v1/payments/pay?uid=${price}&mobile=${mobile}&serial_number=${props.data.serial}`;
      // window.location.href =`http://localhost:8000/api/v1/payments/pay?uid=${price}&mobile=${mobile}&serial_number=${props.data.serial}`;

    return false;
  } catch (error) {
    btnSttus = false;
    myErrors(error);
  }
 }


function roundToNearestThousand(price) {
    return  price;
  // return Math.round(price / 10) * 10;
}
</script>
