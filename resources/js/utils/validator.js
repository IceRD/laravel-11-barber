export const require = (val) => !!val || 'Заполните это поле'

export function errorMessage(error) {
    switch(error) {
        case "validation.required":
            return "Заполните это поле"
        case "validation.lowercase":
            return "Заполните должно быть в нижнем регистре"
        case "validation.min.string":
            return "Значение слишком короткое"
        case "validation.max.string":
            return "Значение слишком длинное"
        case "validation.unique":
            return "Значение должно быть уникальным"
        case "validation.string":
        case "validation.integer":
        case "validation.boolean":
            return "Произошла непредвиденная ошибка"
    }
    return undefined
}
