export const localStoragesLoginRemove = () => {

    localStorage.removeItem('token');
    localStorage.removeItem('users');
    localStorage.removeItem('permissions');
};

export const localStoragesLoginAdd = (response) => {

    localStorage.setItem('token', response.data.data.access_token);
    localStorage.setItem('users', JSON.stringify(response.data.data.list));
    localStorage.setItem('permissions', JSON.stringify(response.data.data.permissions));
};



