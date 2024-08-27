export const rules = {
    require: (str) => !!str || "Заполните это поле",
    min: (str, val) => !!str || `Минимальное кол-во символов: ${val}`,
    max: (str, val) => !!str || `Максимальное кол-во символов: ${val}`,
}

export function errorMessage(error) {
    switch(error) {
        case "validation.required":
            return "Заполните это поле"
        case "validation.lowercase":
            return "Значение должно быть в нижнем регистре"
        case "validation.min.string":
            return "Значение слишком короткое"
        case "validation.max.string":
            return "Значение слишком длинное"
        case "validation.unique":
            return "Значение должно быть уникальным"
        case "validation.current_password":
            return "Значение не соответствует текущему паролю"
        case "validation.string":
        case "validation.integer":
        case "validation.boolean":
            return "Произошла непредвиденная ошибка"
    }
    return undefined
}
