import {useToast} from "vue-toastification";
const toast = useToast();

export function myErrors(error) {
    if (error?.response?.status === 422) {
        const errorMessages = Object.values(error.response.data.errors).map(val => val[0]);
        errorMessages.forEach(errorMessage => {
            toast.error(errorMessage);
        });
    } else if (error?.response?.status === 404) {
        if (error?.response?.data?.messages) {
            toast.error(error?.response?.data?.messages);
        } else {
            toast.error('خطایی رخ داده است؛ لطفا چند دقیقه‌ی دیگر مراجعه کنید یا با پشتیبانی تماس بگیرید...');
        }
    } else {
        toast.error('خطایی رخ داده است؛ لطفا چند دقیقه‌ی دیگر مراجعه کنید یا با پشتیبانی تماس بگیرید..');
    }
}
