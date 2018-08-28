import AuctionHouseListings from './auction-house/AuctionHouseListings.js'
import Search from './search/Search.js'
import ServerDetails from './server/ServerDetails.js'

export default {
  name: 'App',
  data: () => {
    return {
      defaultComponent: 'Search',
      currentComponent: null,
      components: ['Search', 'Auction House', 'Server Details']
    }
  },
  computed: {
    activeComponent: function () {
      return this.getCurrentComponent()
    }
  },
  methods: {
    getCurrentComponent: function () {
      let component = null
      if (this.currentComponent) {
        component = this.currentComponent
      } else {
        component = localStorage.getItem('currentComponent')

        if (!component) {
          component = this.defaultComponent
        }
        this.setCurrentComponent(component)
      }
      return this.getRegisteredComponentName(component)
    },
    getRegisteredComponentName (name) {
      return `app-${name.replace(' ', '').toLowerCase()}`
    },
    getActiveClass: function (tab) {
      return this.getRegisteredComponentName(tab) === this.getCurrentComponent() ?
        'active' : ''
    },
    setCurrentComponent (component) {
      this.currentComponent = component
      localStorage.setItem('currentComponent', component)
    }
  },
  components: {
    'app-auctionhouse': AuctionHouseListings,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  },
  template: `<div>
      <nav>
          <span v-for="component in components" 
                :id="'nav-' + component" 
                :class="'btn ' + getActiveClass(component)" 
                v-on:click="setCurrentComponent(component)">{{ component }}</span>
      </nav>
      <component :is="activeComponent"></component>
    </div>`
}