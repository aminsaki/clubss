import {createRouter, createWebHistory} from 'vue-router'
import  notFound from "@//commons/components/errors/notFound.vue"

import {HomeRoute} from "@/router/homeRoute.js";

const routes = [
  ...HomeRoute,


  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    meta: {layout: notFound}
  }

]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),  // استفاده از import.meta.env
  routes
});

export default router;
