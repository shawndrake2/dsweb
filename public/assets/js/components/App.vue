<template>
  <div>
    <app-header :siteName="siteName"></app-header>
    <div class="container">
      <nav class="navbar is-dark">
        <div class="navbar-menu">
            <a v-for="component in components"
                  :id="'nav-' + component"
                  :class="'navbar-item is-tab ' + getActiveClass(component)"
                  v-on:click="setCurrentComponent(component)">{{ component }}</a>
        </div>
      </nav>
      <component :is="activeComponent"></component>
    </div>
    <app-footer></app-footer>
  </div>
</template>

<script>
import AuctionHouseListings from './auction-house/AuctionHouseListings.vue'
import Character from './character/Character.vue'
import Footer from './Footer.vue'
import Header from './Header.vue'
import NotoriousMonsters from './mobs/NotoriousMonsters.vue'
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
      components: ['Search', 'Auction House', 'Character', 'Server Details', 'Notorious Monsters']
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
        'is-active' : ''
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
    'app-notoriousmonsters': NotoriousMonsters,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  }
}
</script>

<style lang="scss">
  html, body {
    font-family: Verdana, Geneva, sans-serif;
    color: #333;
    margin: 20px 4%;
    padding: 0;
    background: #ddd;

    .container {
      margin: 20px 0;
      background: #fff;
      .page {
        padding: 30px;
      }
      .navbar-item {
        color: white;
        &.is-active {
          color: white;
          border-bottom-color: white;
          border-bottom-width: 5px;
        }
      }
    }
  }
</style>