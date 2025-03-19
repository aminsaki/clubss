<template>
  <div class ="d-flex flex-column card col-md-5 p-4" >
    <table class="table table-striped text-center" dir="rtl">
      <thead>
      <tr>
        <th colSpan="2">
          <i class="fa fa-check-circle fs-1 text-green-600"></i>
          <h5 class="text-green-600 p-3">تراکنش با موفقیت انجام شد</h5>
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-if="ref_id">
        <td class="p-3"><i class="fa fa-receipt text-rose-500"></i> کد رهگیری</td>
        <td class="p-3">{{ref_id}}</td>
      </tr>
      <tr v-if="date">
        <td class="p-3"><i class="fa fa-calendar-alt text-rose-500"></i> زمان</td>
        <td class="p-3">{{dates.converDatePersian(date)}}</td>
      </tr>
      </tbody>
    </table>
  </div>

</template>

<script setup>
import * as dates from '@/commons/helpers/DatePersian.js';
import {ref} from "vue";
import {useRoute} from "vue-router";
const route = useRoute();
const ref_id = ref(route.params.params[1] || 0);
const date = ref(route.params.params[2] || 0);


</script>
