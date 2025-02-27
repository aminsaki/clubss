<template>
  <div class="container d-flex justify-content-center mt-10">
    <div class="col-lg-8 col-md-8">
      <div class="card shadow">
        <div class="d-flex flex-row justify-content-center align-items-center mt-3">
          <img src="@/commons/assets/images/logo.png" class="img-fluid w-25" alt="لوگو">
        </div>
          <componetsIndex/>
      </div>
    </div>
  </div>
</template>
<script setup>
 import componetsIndex from "@/home/components/invoice/index.vue"
</script>


