export const defaulTelnumItem = () => ({
    "number": "",
    "name": ""
})

export const minTelnums = 1;
export const maxTelnums = 3;

export function addTelnumItem(arr) {
    if (arr.length >= maxTelnums) return arr;
    const telnumItem = defaulTelnumItem()
    return [
        ...arr,
        telnumItem
    ]
}

export function removeTelnumItem(arr) {
    if (arr.length <= minTelnums) return arr;
    const telnums = [...arr]
    telnums.splice(-1)
    return telnums
}

