export const converDatePersian = (date) => {
        return new Date(date).toLocaleDateString('fa-IR')
}

export const formatDateTime = (date) => {
        return new Date(date).toLocaleString('fa-IR', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false, // برای نمایش ساعت در فرمت ۲۴ ساعته
        });
}

