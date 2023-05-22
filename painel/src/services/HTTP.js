import axios from 'axios'
import LocalStorage from '../utils/LocalStorage'

const responseHandler = (err) => {
    alert("Erro ao processar dados!")
    return Promise.reject(err);
}

const success = (config) => {
    let data = LocalStorage.get("SESSION_KABUM") || { token: '' }

    if (data.token) {
        config.headers.Authorization = data.token
    }

    return config
}

let axiosInstance = axios.create({
    baseURL: process.env.API
})

axiosInstance.interceptors.request.use(success , responseHandler)

export default axiosInstance