<template>
    <header>
        <div class="columns">
            <div class="column">
                <h1 class="title is-1">
                    {{ siteName }}
                </h1>
            </div>
            <div class="column">
                <app-auth :classes="authStyles"></app-auth>
            </div>
        </div>
    </header>
</template>

<script>
  import Auth from './common/Auth.vue'

  export default {
    name: 'Header',
    components: {
      'app-auth': Auth
    },
    props: {
      siteName: String
    },
    data () {
      return {
        "authStyles": [
          'button',
          'is-dark',
          'is-pulled-right'
        ]
      }
    }
  }
</script>

<style lang="scss">
    header {
        padding: 20px;
    }
</style>