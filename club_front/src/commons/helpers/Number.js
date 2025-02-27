export const numberFormats = (Number) => {
    Number += '';
    Number = Number.replace(',', '');
    Number = Number.replace(',', '');
    Number = Number.replace(',', '');
    Number = Number.replace(',', '');
    Number = Number.replace(',', '');
    Number = Number.replace(',', '');
    let x = Number.split('.');
    let y = x[0];
    let z = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(y))
        y = y.replace(rgx, '$1' + ',' + '$2');
    return y + z;

}

export const removeBracketsFromString = (jsonArray) => {
    return JSON.stringify(jsonArray).replace(/[\[\]"]/g, '');
}

export const validatePhone = (phone) => {
    const phonePattern = /^\d{10,11}$/;
    return phonePattern.test(phone);
};


