// import * as guards from "@/router/guard";
import app from "@/commons/components/loadings/app.vue"
export const HomeRoute = [
  {
    path: '/invoice/:series',
    name: 'invoice',
    component: () => import('@/home/views/invoice/index.vue'),
    meta: {layout: app},
    // beforeEnter: guards.MustBeNotShowButtonGauard
  },
  {
    path: '/payment/status/:params*',
    name: 'paymentStatus',
    meta: {layout: app},
    component: () => import('@/home/views/payment/index.vue')
  },
]
