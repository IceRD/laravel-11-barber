export const partner = import.meta.env.VITE_APP_PARTNER

export function assetsImageUrl(file) {
    return `/assets/images/${file}`
}

export const notify = {
    success: {
        icon: "check",
        type: "positive",
        position: "top",
        message: "Сохранено",
        timeout: 1000,
    }
}

export function telnumFormat(phone) {
    if (!phone) return ""
    let digitsOnly = phone.replace(/\D/g, "");

    return digitsOnly.replace(/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/, "$1 ($2) $3-$4-$5")
}
