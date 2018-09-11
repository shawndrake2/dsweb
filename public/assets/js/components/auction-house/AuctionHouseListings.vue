<template>
    <div class="page">
        <h3>Auction House ({{ listingTotal }})</h3>
        <div v-if="listings.length > 0" class="ah-results">
            <div class="result-headings columns is-centered has-text-weight-semibold">
                <div class="column" v-if="fields.itemId" v-on:click="setSort('item_id')" style="color:#888;">Item Id</div>
                <div class="column" v-if="fields.icon">Icon</div>
                <div class="column" v-if="fields.itemName" v-on:click="setSort('item_name')">Item</div>
                <div class="column" v-if="fields.stack">Stack</div>
                <div class="column" v-if="fields.price" v-on:click="setSort('ah_price')">Price</div>
                <div class="column" v-if="fields.listDate" v-on:click="setSort('ah_date')">List Date</div>
                <div class="column" v-if="fields.salePrice" v-on:click="setSort('ah_sale')">Sale</div>
                <div class="column" v-if="fields.saleDate" v-on:click="setSort('ah_saledate')">Sale Date</div>
                <div class="column" v-if="fields.profit">Profit</div>
                <div class="column" v-if="fields.seller" v-on:click="setSort('character_name')">Character</div>
                <div class="column" v-if="fields.actions" style="color:#A74436;">Actions</div>
            </div>
            <app-listing v-for="(listing, index) in listings" :listing="listing" :key="'listing' + index" :fields="fields" :index="index"></app-listing>
            <div v-if="pages > 1 && currentPage !== 1" v-on:click="prevPage" style="float: left">
                Prev
            </div>
            <div v-if="currentPage < pages" v-on:click="nextPage" style="float: right">
                Next
            </div>
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
  computed: {
    fieldsParam () {
      const fields = []
      for (const key in this.fields) {
        if (this.fields[key]) {
          fields.push(key)
        }
      }
      return fields.join(',')
    },
    pages () {
      return this.listingTotal > this.maxResults ?
        Math.round(this.listingTotal / this.maxResults) : 1
    },
    url () {
      return '/data/auction-house' +
        `?fields=${this.fieldsParam}` +
        `&max_results=${this.maxResults}` +
        `&page=${this.currentPage}` +
        `&sort=${this.sort}` +
        `&sort_order=${this.sortOrder}` +
        `&status=${this.status}`
    }
  },
  created () {
    this.fetchData()
  },
  data () {
    return {
      currentPage: 1,
      errors: [],
      // @TODO Make fields editable
      fields: {
        actions: false,
        icon: true,
        itemId: false,
        itemName: true,
        listDate: true,
        price: true,
        profit: false,
        saleDate: false,
        salePrice: false,
        seller: true,
        stack: true
      },
      listings: [],
      listingTotal: 0,
      // @TODO Make this editable
      maxResults: 20,
      sort: 'ah_id',
      sortOrder: 'asc',
      // @TODO Default status to 'all'
      status: 'unsold'
    }
  },
  methods: {
    fetchData() {
      fetch(this.url)
        .then(response => {
          return response.json()
        })
        .then(json => {
          this.listings = json.listings
          this.listingTotal = json.total
        })
        .catch(e => {
          console.log(e)
        })
    },
    nextPage() {
      this.currentPage++
      this.fetchData()
    },
    prevPage() {
      this.currentPage--
      this.fetchData()
    },
    setSort(name) {
      if (this.sort === name) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc'
      } else {
        this.sortOrder = 'asc'
        this.sort = name
      }
      this.fetchData()
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