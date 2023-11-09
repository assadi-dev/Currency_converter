import { createApp } from 'vue'
import './style.css'
import './responsive.css'
import App from './App.vue'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import router from './router';
import "primevue/resources/themes/saga-blue/theme.css"
import 'primeflex/primeflex.css'
import 'primeicons/primeicons.css'





const app = createApp(App)



app.use(router)
app.use(PrimeVue);
app.use(ToastService);

app.mount('#app')