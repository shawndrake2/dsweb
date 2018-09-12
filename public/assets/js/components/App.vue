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
    'app-notoriousmonsters': NotoriousMonsters,
    'app-search': Search,
    'app-serverdetails': ServerDetails
  }
}
</script>

<style lang="scss">
  html, body {
    font-size: 12px;
    font-family: Verdana;
    color: #333;
    margin: 20px 4%;
    padding: 0;
    background: #ddd;
  }
  form input, form textarea, .form input, .form textarea {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;

    border:solid 1px #ccc;
    border-bottom:solid 3px #ccc;
    box-shadow: 0 1px 3px #e5e5e5;

    border-radius: 3px;
    padding: 8px 12px;
    font-size: 12px;
    color: #666;
    outline: none;
    margin: 0;
    vertical-align: bottom;
  }
  form textarea, .form textarea {
    font-family: Verdana;
    color: #666;
  }
  form input, form textarea, .form input, .form textarea {
    background: #fff;
  }
  form input:hover, form textarea:hover, .form input:hover, .form textarea:hover {
    border:solid 1px #82B0D2;
    border-bottom:solid 3px #82B0D2;
  }
  form input[type=submit], form input[type=button], form input[type=reset],form button,
  .form input[type=submit], .form input[type=button], .form input[type=reset], .form button {
    color: #000;
    font-weight: bold;
    font-size: 12px;
    background: rgb(247,247,247);
    background: -moz-linear-gradient(top,  rgba(247,247,247,1) 0%, rgba(229,229,229,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(247,247,247,1)), color-stop(100%,rgba(229,229,229,1)));
    background: -webkit-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(229,229,229,1) 100%);
    background: -o-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(229,229,229,1) 100%);
    background: -ms-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(229,229,229,1) 100%);
    background: linear-gradient(to bottom,  rgba(247,247,247,1) 0%,rgba(229,229,229,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#e5e5e5',GradientType=0 );
  }
  form input[type=submit]:hover, form input[type=button]:hover, form input[type=reset]:hover,form button:hover,
  .form input[type=submit]:hover, .form input[type=button]:hover, .form input[type=reset]:hover, .form button:hover {
    cursor: pointer;
    color: #005BF4;
    background: rgb(250,250,250);
    background: -moz-linear-gradient(top,  rgba(250,250,250,1) 0%, rgba(237,237,237,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(250,250,250,1)), color-stop(100%,rgba(237,237,237,1)));
    background: -webkit-linear-gradient(top,  rgba(250,250,250,1) 0%,rgba(237,237,237,1) 100%);
    background: -o-linear-gradient(top,  rgba(250,250,250,1) 0%,rgba(237,237,237,1) 100%);
    background: -ms-linear-gradient(top,  rgba(250,250,250,1) 0%,rgba(237,237,237,1) 100%);
    background: linear-gradient(to bottom,  rgba(250,250,250,1) 0%,rgba(237,237,237,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fafafa', endColorstr='#ededed',GradientType=0 );
  }
  h1 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 25px;
    font-family: Arial;
  }
  h2 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 22px;
    font-family: Arial;
    color: #0057C1;
  }
  h3 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 18px;
    font-family: Arial;
  }
  h4 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 15px;
    font-family: Arial;
  }
  h5 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 14px;
    font-family: Arial;
    color: #0057C1;
    font-weight: bold;
  }
  h6 {
    margin: 0 0 15px 0;
    padding: 0;
    font-size: 13px;
    font-family: Arial;
  }
  p {
    margin: 0 0 15px 0;
  }
  nav {
    display: block;
    border-bottom:solid 1px #ccc;
    position: relative;
    z-index: 1;
  }
  nav .btn {
    display: inline-block;
    font-size: 13px;
    padding: 10px 15px;
    margin: 0 -5px 0 0;
    background: none;
    opacity: 0.6;
  }
  nav .btn:hover {
    opacity: 1;
    cursor: pointer;
    color: #0E7BB6;
  }
  nav .active {
    color: #0E7BB6;
    background: #eee;
    opacity: 1;
    border:solid 1px #ccc;
    border-top:none;
    border-bottom:none;
    box-shadow: inset 0 1px 0 #ccc;
    padding: 10px 14px;
  }
  .container {
    margin: 20px 0;
    background: #fff;
    min-height: 200px;
    border-radius: 2px;
    box-shadow: inset 0 0 2px #555;
  }
  .page {
    padding: 30px;
    font-family: Arial;
  }
  .success, .error
  {
    padding: 10px;
    border-radius: 2px;
    color: #fff;
    text-shadow:1px 1px 1px #555;
  }
  .success
  {
    border-left:solid 3px #3E860D;
    background: rgb(126,182,36);
    background: -moz-linear-gradient(top,  rgba(126,182,36,1) 0%, rgba(99,148,30,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(126,182,36,1)), color-stop(100%,rgba(99,148,30,1)));
    background: -webkit-linear-gradient(top,  rgba(126,182,36,1) 0%,rgba(99,148,30,1) 100%);
    background: -o-linear-gradient(top,  rgba(126,182,36,1) 0%,rgba(99,148,30,1) 100%);
    background: -ms-linear-gradient(top,  rgba(126,182,36,1) 0%,rgba(99,148,30,1) 100%);
    background: linear-gradient(to bottom,  rgba(126,182,36,1) 0%,rgba(99,148,30,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7eb624', endColorstr='#63941e',GradientType=0 );
  }
  .error
  {
    border-left:solid 3px #DF8686;
    background: rgb(182,36,41);
    background: -moz-linear-gradient(top,  rgba(182,36,41,1) 0%, rgba(148,30,30,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(182,36,41,1)), color-stop(100%,rgba(148,30,30,1)));
    background: -webkit-linear-gradient(top,  rgba(182,36,41,1) 0%,rgba(148,30,30,1) 100%);
    background: -o-linear-gradient(top,  rgba(182,36,41,1) 0%,rgba(148,30,30,1) 100%);
    background: -ms-linear-gradient(top,  rgba(182,36,41,1) 0%,rgba(148,30,30,1) 100%);
    background: linear-gradient(to bottom,  rgba(182,36,41,1) 0%,rgba(148,30,30,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b62429', endColorstr='#941e1e',GradientType=0 );
  }
</style>