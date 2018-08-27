import Search from './search/Search.js'

export default {
  name: 'App',
  components: {
    'app-search': Search
  },
  template: `<div>
        <app-search></app-search>
    </div>`
}