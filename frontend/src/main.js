import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsExample from '@/components/DocsExample'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faEye, faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Pagination from 'v-pagination-3'
import Toaster from '@meforma/vue-toaster'

const app = createApp(App)

library.add([faEdit, faEye, faTrash])

app.use(store)
app.use(router)
app.use(CoreuiVue)
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.component('DocsExample', DocsExample)
app.component('FontAwesomeIcon', FontAwesomeIcon)
app.component('pagination', Pagination)
app.use(Toaster)
app.mount('#app')
