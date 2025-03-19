<template>
  <section>
    <div class="row d-flex justify-content-center  ">
      <!--    success   UNSUCCESSFUL-->
      <div class="  col-md-10 p-2 " v-if="MethodState(status) === 'SUCCESSFUL'" style="direction: rtl">
        <otp></otp>
      </div>
      <!--      errors  UNKNOWN -->
      <div class="d-flex flex-column card col-md-5  text-center" v-else>
        <table class="table table-striped" style="direction: rtl">
          <thead>
          <tr>
            <th colspan="2">
              <i class="fa fa-times-circle fs-1 text-rose-500 "></i>
              <h5 class="text-danger p-3">متاسفانه پرداخت شما ناموفق بود </h5>
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="ref_id ">
            <td class="p-3"><i class="fa fa-receipt text-rose-500  "></i> کد رهگیری</td>
            <td class="p-3">{{ ref_id }}</td>
          </tr>

          <tr v-if="date ">
            <td class="p-3 ms-2 "><i class="fa fa-calculator text-rose-500 ms-2 "></i>تاریخ تراکنش </td>
            <td class="p-3">{{ dates.converDatePersian(date) }}</td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>
  </section>
</template>
<script setup>
import {useRoute} from 'vue-router'
import * as dates from "@/commons/helpers/DatePersian.js";
import {$ref} from 'unplugin-vue-macros/macros';
import {data} from "autoprefixer";

import  Otp from "@/home/views/otp/index.vue"
const route = useRoute()
let status = $ref(route.params.params[0]);
let ref_id = $ref((route.params.params[1]) ? route.params.params[1] : 0);
let date = $ref((route.params.params[2]) ? route.params.params[2] : 0);
function MethodState(status) {
  if (status === "SUCCESSFUL") {
    return "SUCCESSFUL";
  }
  return "UNKNOWN";
}

</script>
<style >
.table > thead {
  text-align: center !important;
}
</style>
