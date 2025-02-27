import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import axios from 'axios'
const app = createApp(App)

///#toastification
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
///#fonts
import "@/commons/assets/fonts/fontawesome-free/css/all.min.css"
import "@/commons/assets/css/iransans.css"

///#bootsraps
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import 'bootstrap/js/dist/popover.js';
//#tailwindcss
import '@/commons/assets/css/index.css'
import VueAxios from "vue-axios";

// import webUrls from "@/../config/dev.json";
 import webUrls from "@/../config/prod.json";

axios.defaults.headers.common['Authorization'] = localStorage.getItem('token');
axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET, PUT, POST, DELETE, OPTIONS, post, get';
axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'X-Requested-With';
axios.defaults.baseURL = webUrls.BASE_URL;

webUrls.BASE_URL.startsWith('http://')
  ? webUrls.BASE_URL.replace('http://', 'https://')
  : webUrls.BASE_URL;

const Backurl = webUrls.BACKEND_URL;

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)
app.use(VueSweetalert2);
app.mount('#app')
