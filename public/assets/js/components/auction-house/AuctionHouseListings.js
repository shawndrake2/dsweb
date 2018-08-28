import Listing from './Listing.js'

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
  },
  template: `
    <div class="page">
        <h3>Auction House</h3>
        <div v-if="listings.length > 0">
          <table class="generic-table" cellspacing="0" border="0" cellpadding="10">
              <tr class="generic-table-header">
                  <td width="2%" align="center" style="color:#888;">#</td>
                  <td width="2%" align="center">Icon</td>
                  <td width="25%">Item</td>
                  <td width="2%" align="center">Stack</td>
                  <td width="10%" align="right">Price</td>
                  <td width="15%">List Date</td>
                  <td width="10%" align="right">Sale</td>
                  <td width="15%">Sale Date</td>
                  <td width="10%">Profit</td>
                  <td width="15%">Character</td>
                  <td width="15%" align="center" style="color:#A74436;">Actions</td>
              </tr>
              <app-listing v-for="listing in listings" :listing="listing"></app-listing>
          </table>
        </div>  
        <div class="error" v-if="listings.length === 0">
            There is nothing for sale on the Auction House.
        </div>
    </div>
    `
}