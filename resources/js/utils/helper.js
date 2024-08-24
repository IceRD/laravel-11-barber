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
