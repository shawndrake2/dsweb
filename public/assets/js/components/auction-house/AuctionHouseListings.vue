<template>
    <div class="page">
        <h3>Auction House</h3>
        <div v-if="listings.length > 0">
            <table class="generic-table" cellspacing="0" border="0" cellpadding="10">
                <tr class="generic-table-header">
                    <th width="2%" align="center" style="color:#888;">#</th>
                    <th width="2%" align="center">Icon</th>
                    <th width="25%">Item</th>
                    <th width="2%" align="center">Stack</th>
                    <th width="10%" align="right">Price</th>
                    <th width="15%">List Date</th>
                    <th width="10%" align="right">Sale</th>
                    <th width="15%">Sale Date</th>
                    <th width="10%">Profit</th>
                    <th width="15%">Character</th>
                    <th width="15%" align="center" style="color:#A74436;">Actions</th>
                </tr>
                <app-listing v-for="(listing, index) in listings" :listing="listing" :key="'listing' + index"></app-listing>
            </table>
        </div>
        <div class="error" v-if="listings.length === 0">
            There is nothing for sale on the Auction House.
        </div>
    </div>
</template>

<script>
import Listing from './Listing.vue'

export default {
  name: 'AuctionHouseListings',
  components: {
    'app-listing': Listing
  },
  created () {
    fetch('http://dsweb.local/data/auction-house')
      .then(response => {
        return response.json()
      })
      .then(json => {
        this.listings = json
      })
      .catch(e => {
        console.log(e)
      })
  },
  data () {
    return {
      errors: [],
      listings: []
    }
  }
}
</script>

<style>

</style>