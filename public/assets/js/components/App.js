import AuctionHouseListings from './auction-house/AuctionHouseListings.js'
import Footer from './Footer.js'
import Header from './Header.js'
import Search from './search/Search.js'
import ServerDetails from './server/ServerDetails.js'

const siteName = window.siteName;

export default {
  name: 'App',
  data: () => {
    return {
      siteName: siteName,
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
    'app-footer': Footer,
    'app-header': Header,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  },
  template: `
    <div>
      <app-header :siteName="siteName"></app-header>

      <!-- TESTING -->
      <div style="margin:20px 0;">
          <input type="button" value="Load character" onclick="test.editCharacter()" />
      </div>
      <!-- TESTING -->

      <div class="container">
  
        <nav>
            <span v-for="component in components" 
                  :id="'nav-' + component" 
                  :class="'btn ' + getActiveClass(component)" 
                  v-on:click="setCurrentComponent(component)">{{ component }}</span>
        </nav>
  
        <component :is="activeComponent"></component>

        <div id="ajax">

        </div>
  
      </div>

      <app-footer></app-footer>
  
    </div>
`
}