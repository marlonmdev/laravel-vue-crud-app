import { createApp } from 'vue'
import App from './App.vue'
import Router from './router';
import axios from 'axios'
import './assets/main.css';

axios.defaults.baseURL = 'http://localhost:8000/';

createApp(App)
    .use(Router)
    .mount('#app')
