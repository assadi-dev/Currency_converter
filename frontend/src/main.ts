import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import PrimeVue from 'primevue/config';
import router from './router';
import "primevue/resources/themes/saga-blue/theme.css"
import adminRouter from './router/adminRouter';


const app = createApp(App)



app.use({...router})
app.use(PrimeVue);

app.mount('#app')