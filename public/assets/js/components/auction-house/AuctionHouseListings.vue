<template>
    <div class="page">
        <h3>Auction House</h3>
        <div v-if="listings.length > 0" class="ah-results">
            <div class="result-headings columns is-centered has-text-weight-semibold">
                <div class="column" style="color:#888;">#</div>
                <div class="column">Icon</div>
                <div class="column">Item</div>
                <div class="column">Stack</div>
                <div class="column">Price</div>
                <div class="column">List Date</div>
                <div class="column">Sale</div>
                <div class="column">Sale Date</div>
                <div class="column">Profit</div>
                <div class="column">Character</div>
                <div class="column" style="color:#A74436;">Actions</div>
            </div>
            <app-listing v-for="(listing, index) in listings" :listing="listing" :key="'listing' + index"></app-listing>
            <!--<div style="float: right">-->
                <!--Next-->
            <!--</div>-->
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
    .ah-results {
        width: 100%;
        margin: 0 0 20px 0;
        border-top:solid 1px #ddd;
        border-left:solid 1px #ddd;
        box-shadow: 0 2px 0 #eee;
    }
    .result-headings .column {
        color: #000;
        box-shadow: 0 2px 0 #eee;
        padding: 5px 10px;
    }
    .ah-results .column {
        border-right: solid 1px #ddd;
        border-bottom:solid 1px #ddd;
        font-size: 12px;
    }
    .ah-results .column:hover {
        background-color: #f5f5f5;
    }
</style>