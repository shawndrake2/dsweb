import Vue from 'vue'
import App from './components/App.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCheck, faEdit, faTimes } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// Global styles
import 'bulma/css/bulma.css'

library.add(faCheck)
library.add(faEdit)
library.add(faTimes)

Vue.component('font-awesome-icon', FontAwesomeIcon)

new Vue({
  render: h => h(App)
}).$mount('#app')
