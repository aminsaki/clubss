<template>
  <component :is="layout" >
    <router-view/>
  </component>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import LoadingAll  from "@/commons/components/loadings/app.vue";

const route = useRoute();
const layout = computed(() => {
  return route.meta.layout ? route.meta.layout : 'default-layout';
});


</script>
