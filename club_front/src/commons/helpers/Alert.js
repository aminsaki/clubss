import { useToast } from "vue-toastification";
const toast = useToast();
export function mySuccess(msg) {

     toast.mySuccess("عملیات با موففیعت انجام شده", {
          position: "top-left",
          timeout: 1223,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 2,
          showCloseButtonOnHover: true,
          hideProgressBar: true,
          closeButton: false,
          icon: true,
          rtl: true
     });
}

export function  myWarnign(msg) {
     toast.warning(msg, {
          position: "top-center",
          timeout: 1223,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 2,
          showCloseButtonOnHover: true,
          hideProgressBar: true,
          closeButton: false,
          icon: true,
          rtl: true
     });
}

export function Myerror(msg) {
     toast.error(msg, {
          position: "top-center",
          timeout: 1223,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 2,
          showCloseButtonOnHover: true,
          hideProgressBar: true,
          closeButton: false,
          icon: true,
          rtl: true
     });
}


export function MyInfo(msg) {
     toast.info(msg, {
          position: "top-center",
          timeout: 1223,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 2,
          showCloseButtonOnHover: true,
          hideProgressBar: true,
          closeButton: false,
          icon: true,
          rtl: true
     });
}

