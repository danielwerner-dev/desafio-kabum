export default  {
    add: (key, data) => localStorage.setItem(key, JSON.stringify(data)),
    remove: key => localStorage.removeItem(key),
    get: key => JSON.parse(localStorage.getItem(key)),
    getAll: () =>  localStorage
}