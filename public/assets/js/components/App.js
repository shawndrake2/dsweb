import AuctionHouseListings from './auction-house/AuctionHouseListings.js'
import Search from './search/Search.js'
import ServerDetails from './server/ServerDetails.js'

// Defined at PHP level for simplicity
const serverConfig = window.serverConfig;

export default {
  name: 'App',
  data: () => {
    return {
      serverConfig: serverConfig,
      currentComponent: 'Search',
      components: ['Search', 'AuctionHouse', 'ServerDetails']
    }
  },
  computed: {
    getCurrentComponent: function () {
      if (this.currentComponent) {
        return 'app-' + this.currentComponent.toLowerCase()
      }
      return ''
    }
  },
  components: {
    'app-auctionhouse': AuctionHouseListings,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  },
  template: `<div>
      <nav>
          <span class="btn active" v-on:click="currentComponent = 'Search'">Search</span>
          <span class="btn" v-on:click="currentComponent = 'AuctionHouse'">Auction House</span>
          <span class="btn" v-on:click="currentComponent = 'ServerDetails'" v-if="serverConfig">Server</span>
      </nav>
      <component :is="getCurrentComponent"></component>
    </div>`
}