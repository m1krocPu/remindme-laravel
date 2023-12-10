import './bootstrap';

import { createApp } from 'vue'
import router from './router';

const app = createApp()
app.use(router)
app.mount('#remindme-app')
