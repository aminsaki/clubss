export const AuthUser = (to,from, next) => {
    document.title = to.meta?.title ?? 'صفحه اصلی'
    let token = localStorage.getItem('token');
    let users = localStorage.getItem('users');
    if (token && users) {
        return next({path: '/panel/dashboard'});
    }
    return next();
};

