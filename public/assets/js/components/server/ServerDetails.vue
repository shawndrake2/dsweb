<template>
    <div class="page">
        <h2 class="title is-3">Server Configuration</h2>
        <div v-if="!isEmpty(serverConfig)">
            <div class="columns">
                <div class="column title is-5">Name</div>
                <div class="column title is-5">Value</div>
            </div>
            <div class="columns" v-for="(value, key) in serverConfig">
                <div class="column">{{ key }}</div>
                <div class="column">{{ value }}</div>
            </div>
        </div>
        <div class="notification is-danger" v-if="isEmpty(serverConfig)">
            There is nothing for sale on the Auction House.
        </div>
    </div>
</template>

<script>
export default {
  name: 'ServerDetails',
  created () {
    fetch('/data/server')
      .then(response => {
        return response.json()
      })
      .then(json => {
        this.serverConfig = json
      })
      .catch(e => {
        console.log(e)
      })
  },
  data () {
    return {
      serverConfig: []
    }
  },
  methods: {
    isEmpty (obj) {
      return !obj || Object.keys(obj).length === 0;
    }
  }
}
</script>

<style>

</style>