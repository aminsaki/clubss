import * as alert from "@/common/helpers/Alert";
import {myErrors} from "@/common/helpers/errors";
import {MyInfo} from "@/common/helpers/Alert";

export function ValidatePersian(e) {

    let char = String.fromCharCode(e.keyCode);
    componeName(e, e.target.value);

    // Get the character
    if (!/^[A-Za-z]+$/.test(char)) {
        return true; // Match with regex
    }
    if (e.keyCode !== 32) {
        e.target.value = " ";
        alert.Myerror("لطفا فقط حروف فارسی وارد کنید");
        e.preventDefault(); // If not match, don't add to input text
        return false;
    }
}

export function ValidateNumber(e) {

    let char = String.fromCharCode(e.keyCode);

    // Get the character
    if (/^\d+$/.test(char)) {
        return true; // Match with regex
    }
    e.target.value = " ";
    alert.Myerror("لطفا فقط اعداد وارد کنید");

    e.preventDefault(); // If not match, don't add to input text
    return false;
}

export function componeName(e, value) {
    let inputValue = e.target.value;

    // Define filter words
    const filterWords = ["شرکت", "موسسه", "آموزشگاه", "مزگر"];

    // Function to filter words and display an error if needed
    function filterAndCheckError(text) {
        let modifiedText = text;
        filterWords.forEach(word => {
            modifiedText = modifiedText.replace(new RegExp(word, 'g'), '');
        });

        if (text !== modifiedText) {
            alert.Myerror("لطفاً از کلمات ممنوعه استفاده نکنید");
            e.target.value = ""
            return false; // Error occurred
        }
    }

    // Check for errors
    if (filterAndCheckError(inputValue)) {
        e.target.value = inputValue;
    }

}

export const checkMelliCode = (melliCode) => {
    if (!/^\d{10}$/.test(melliCode)) {
        alert.Myerror("کد ملی صحیح نمی‌باشد");
        return false;
    }

    let code = melliCode;
    let sum = 0;

    for (let i = 0; i < 9; i++) {
        sum += parseInt(code[i]) * (10 - i);
    }
    let remainder = sum % 11;
    let checkDigit = parseInt(code[9]);

    if((remainder < 2 && checkDigit === remainder) || (remainder >= 2 && checkDigit === 11 - remainder)) {
        return true;
    }
    alert.Myerror("کد ملی صحیح نمی‌باشد");
}

export const isNumberKey = (evt) => {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

export const validateFullNameEn = (params) => {

    const regex = /^[a-zA-Z\s]*$/;
    if (!regex.test(params)) {
        alert.Myerror('نام یا نام خانوادگی باید فقط شامل حروف انگلیسی باشد');
        return false;
    }
    return true;
}
export const validateFullNameFa = (params) => {

    const regex = /^[a-zA-Z\s]*$/;
    if (regex.test(params)) {
        alert.Myerror('نام یا نام خانوادگی باید فقط شامل حروف فارسی باشد');
        return false;
    }
    return true;
}

export const agent_name = (params) => {

    const regex = /^[a-zA-Z\s]*$/;
    if (regex.test(params)) {
        alert.Myerror('نام نمایندگی باید فقط شامل حروف فارسی باشد');
        return false;
    }
    return true;
}
export const validatePhones =(phone) => {
    let phonePattern = /^\d{10,11}$/;
    return phonePattern.test(phone);
}
