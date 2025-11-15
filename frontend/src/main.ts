import App from '@/App.vue';
import router from '@/router';
import { createApp } from 'vue';

import { IonicVue } from '@ionic/vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

/* Core CSS required for Ionic components to work properly */
import '@ionic/vue/css/core.css';

/* Basic CSS for apps built with Ionic */
import '@ionic/vue/css/normalize.css';
import '@ionic/vue/css/structure.css';
import '@ionic/vue/css/typography.css';

/* Optional CSS utils that can be commented out */
import '@ionic/vue/css/display.css';
import '@ionic/vue/css/flex-utils.css';
import '@ionic/vue/css/float-elements.css';
import '@ionic/vue/css/padding.css';
import '@ionic/vue/css/text-alignment.css';
import '@ionic/vue/css/text-transformation.css';

/**
 * Ionic Dark Mode
 * -----------------------------------------------------
 * For more info, please see:
 * https://ionicframework.com/docs/theming/dark-mode
 */

/* @import '@ionic/vue/css/palettes/dark.always.css'; */
/* @import '@ionic/vue/css/palettes/dark.class.css'; */
// import '@ionic/vue/css/palettes/dark.system.css';

/* Theme variables */
import '@/assets/tailwind.css';
import '@/theme/variables.css';
import 'material-icons/iconfont/material-icons.css';

const app = createApp(App)
    .use(IonicVue, {
        mode: 'ios', // or 'md' for material design
    })
    .use(router)
    .use(Toast, {
        transition: 'Vue-Toastification__bounce',
        maxToasts: 5,
        newestOnTop: true,
        position: 'top-right',
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        closeButton: 'button',
        icon: true,
        rtl: false,
    });

router.isReady().then(() => {
    app.mount('#app');
});
