<template>
    <div class="page">
        <h2 class="title is-3">Auction House ({{ listingTotal }})</h2>
        <div class="columns">
            <div class="sidebar-left column">
                <div v-if="listings.length > 0" class="ah-results">
                    <app-listing v-for="(listing, index) in listings" :listing="listing" :key="'listing' + index" :fields="fields" :index="index"></app-listing>
                    <app-pagination
                            :currentPage="currentPage"
                            :totalPages="pages"
                            v-on:previous-page="prevPage"
                            v-on:next-page="nextPage"
                            v-on:goto-page="setPage($event)"></app-pagination>
                </div>
                <div class="notification is-danger" v-if="listings.length === 0">
                    There is nothing for sale on the Auction House.
                </div>
            </div>
            <div class="sidebar-right column is-one-quarter" v-if="listings.length > 0">
                <div class="title is-5">Items Per Page</div>
                <div class="field" v-for="n in 5">
                    <input class="is-checkradio"
                           :id="'limit-' + n"
                           type="radio"
                           name="limit"
                           :value="n * 20"
                           :checked="(n * 20) === maxResults"
                           v-model="maxResults">
                    <label :for="'limit-' + n">{{ n * 20 }}</label>
                </div>
                <div class="title is-5">Auction Status</div>
                <div class="field" v-for="(label, value) in statusOptions">
                    <input class="is-checkradio"
                           :id="'status-' + value"
                           type="radio"
                           name="status"
                           :value="value"
                           :checked="value === status"
                           v-model="status">
                    <label :for="'status-' + value">{{ label }}</label>
                </div>
                <div class="title is-5">Sort By</div>
                <div class="field" v-for="(label, value) in sortOptions">
                    <input class="is-checkradio"
                           :id="'sortBy-' + value"
                           type="radio"
                           name="sortBy"
                           :value="value"
                           :checked="value === sort"
                           v-model="sort">
                    <label :for="'sortBy-' + value">{{ label }}</label>
                </div>
                <div class="title is-5">Sort Order</div>
                <div class="field">
                    <input id="sortOrder"
                           type="checkbox"
                           name="sortOrder"
                           class="switch"
                           :checked="sortOrder === 'desc'"
                           v-model="toggleSort" >
                    <label for="sortOrder">{{ sortOrder.toUpperCase() }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Listing from './Listing.vue'
import Pagination from '../Pagination.vue'

export default {
  name: 'AuctionHouseListings',
  components: {
    'app-listing': Listing,
    'app-pagination': Pagination
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
        Math.ceil(this.listingTotal / this.maxResults) : 1
    },
    sortOrder () {
      return this.toggleSort ? 'desc' : 'asc'
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
    const maxResults = localStorage.getItem('ahListings_maxResults')
    if (maxResults) {
      this.maxResults = maxResults
    }
    const sort = localStorage.getItem('ahListings_sort')
    if (sort) {
      this.sort = sort
    }
    const status = localStorage.getItem('ahListings_status')
    if (status) {
      this.status = status
    }
    const toggleSort = localStorage.getItem('ahListings_toggleSort')
    if (toggleSort) {
      this.toggleSort = toggleSort
    }
  },
  data () {
    return {
      currentPage: 1,
      errors: [],
      // @TODO Make fields editable
      fields: {
        actions: true,
        icon: true,
        itemId: true,
        itemName: true,
        listDate: true,
        price: true,
        profit: true,
        saleDate: true,
        salePrice: true,
        seller: true,
        stack: true
      },
      initialized: false,
      listings: [],
      listingTotal: 0,
      maxResults: 20,
      sort: 'item_name',
      sortOptions: {
        "item_id": "Item Id",
        "item_name": "Item",
        "ah_price": "Price",
        "ah_date": "List Date",
        "ah_sale": "Sale",
        "ah_saledate": "Sale Date",
        "character_name": "Character"
      },
      toggleSort: false,
      status: 'all',
      statusOptions: {
        "all": "All",
        "sold": "Sold",
        "unsold": "Active"
      },
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
    setPage(pageNum) {
      this.currentPage = pageNum
      this.fetchData()
    }
  },
  watch: {
    // @TODO Right now when the component is built, data is fetched for every stored configuration when it gets set
    //       from local storage. We need a better way to manage this
    maxResults: function () {
      localStorage.setItem('ahListings_maxResults', this.maxResults)
      this.fetchData()
    },
    sort: function () {
      localStorage.setItem('ahListings_sort', this.sort)
      this.fetchData()
    },
    status: function () {
      localStorage.setItem('ahListings_status', this.status)
      this.fetchData()
    },
    toggleSort: function () {
      localStorage.setItem('ahListings_toggleSort', this.toggleSort)
      this.fetchData()
    }
  }
}
</script>

<style lang="scss">
    .ah-results {
        margin: 0 0 20px 0;
        .button {
            margin-bottom: 20px;
        }
        .result-headings {
            .column {
                color: #000;
                padding: 5px 10px;
            }
        }
        .column {
            border: solid 1px #ddd;
            &:hover {
                background-color: #f5f5f5;
            }
        }
    }
</style>