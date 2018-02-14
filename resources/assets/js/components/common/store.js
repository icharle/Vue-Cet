export default {
    get(STORAGE_KEY) { //获取
        return JSON.parse(window.localStorage.getItem(STORAGE_KEY ||'[]'))
    },
    set(STORAGE_KEY,items) { //存储
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(items))
    }
}