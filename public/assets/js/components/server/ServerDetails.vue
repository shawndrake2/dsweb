<template>
    <div class="page">
        <h3>Server Configuration</h3>
        <div v-if="!isEmpty(serverConfig)">
            <table class="generic-table" cellspacing="0" border="0" cellpadding="10">
                <tr class="generic-table-header">
                    <th>Name</th>
                    <th>Value</th>
                </tr>
                <tr v-for="(value, key) in serverConfig">
                    <td>{{ key }}</td>
                    <td>{{ value }}</td>
                </tr>
            </table>
        </div>
        <div class="error" v-if="isEmpty(serverConfig)">
            There is nothing for sale on the Auction House.
        </div>
    </div>
</template>

<script>
export default {
  name: 'ServerDetails',
  created () {
    fetch('http://dsweb.local/data/server')
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