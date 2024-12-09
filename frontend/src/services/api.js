import axios from "axios";
import Cookies from "js-cookie";

const api = axios.create({
    baseURL: "http://localhost:8000", 
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true 
});

api.interceptors.request.use((config) => {
    const token = Cookies.get('XSRF-TOKEN');
    console.log("seu token:", token);
    if (token) {
        config.headers['X-XSRF-TOKEN'] = token;
    }
    return config;
});

export default api;
