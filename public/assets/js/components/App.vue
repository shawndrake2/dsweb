<template>
  <div>
    <app-header :siteName="siteName"></app-header>

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
</template>

<script>
import AuctionHouseListings from './auction-house/AuctionHouseListings.vue'
import Character from './character/Character.vue'
import Footer from './Footer.vue'
import Header from './Header.vue'
import Search from './search/Search.vue'
import ServerDetails from './server/ServerDetails.vue'

const siteName = window.siteName;

export default {
  name: 'App',
  data: () => {
    return {
      siteName: siteName,
      defaultComponent: 'Search',
      currentComponent: null,
      components: ['Search', 'Auction House', 'Character', 'Server Details']
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
    'app-character': Character,
    'app-footer': Footer,
    'app-header': Header,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  }
}
</script>

<style>

</style>