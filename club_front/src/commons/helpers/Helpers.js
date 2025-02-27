export function clearBrowserCache() {
    if ('caches' in window) {
        caches.keys().then(function (names) {
            for (let name of names) caches.delete(name);
        });
    }
}

export function pages(to) {
    const pageNumber = Number(to);
    if (isNaN(pageNumber)) {
        return '';
    }
    return pageNumber + 1;
}

export const extractedData = () => {
    let countNumbers = [];
    for (let [key] of Object.entries(localStorage)) {
        if (key.includes("question")) {
            try {
                const parsedData = JSON.parse(localStorage.getItem(key));
                countNumbers.push(parsedData);
            } catch (e) {
                console.error(`Error parsing data for key: ${key}`, e);
            }
        }
    }
    return countNumbers;
};

export const clearLocalStorage = () => {
    localStorage.clear();
};

export const userData = () => {
    return JSON.parse(localStorage.getItem('users'));
}
export const userDataId = () => {
    return JSON.parse(localStorage.getItem('users')).id;
}
export const catData = () => {
    return JSON.parse(localStorage.getItem('cats'));
}
export const cat_id = () => {
    return localStorage.getItem('cat_id');
}
