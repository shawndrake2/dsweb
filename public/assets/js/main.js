import Vue from 'vue'
import App from './components/App.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faLayerGroup } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// Global styles
import 'bulma/css/bulma.css'
import 'bulma-checkradio'
import 'bulma-switch'
import 'bulma-tooltip'

library.add(faEdit)
library.add(faLayerGroup)

Vue.component('font-awesome-icon', FontAwesomeIcon)

new Vue({
  render: h => h(App)
}).$mount('#app')
