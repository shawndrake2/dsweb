import Vue from 'vue'
import App from './components/App.vue'

// Global styles
import '../css/styles.css'
import '../css/styles_compressed.css'

new Vue({
  render: h => h(App)
}).$mount('#app')
