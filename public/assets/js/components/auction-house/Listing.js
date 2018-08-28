export default {
  name: 'Listing',
  props: {
    listing: Object
  },
  data () {
    return {
      minute: 60,
      hour: this.minute * 60,
      day: this.hour * 24
    }
  },
  methods: {
    getAction (listing) {
      return this.getSoldTime(listing) === '-' ?
        '<input type="button" value="Buy" style="padding:5px 8px;" />' :
        ''
    },
    getAhPrice (listing) {
      return Number.parseFloat(listing['ah_price'])
    },
    getAuctionTimeAsString(listingDate) {
      const now = moment()
      listingDate = moment.unix(listingDate)
      const diff = now.subtract(listingDate.seconds())

      if (diff.seconds() === 0) {
        // Instant
        return '<span style="font-weight:bold;">a few ms ago</span>'
      } else if (diff < this.minute) {
        // Few seconds ago
        return `<span style='font-weight:bold;'>${diff} secs</span>`
      } else if (diff < this.hour) {
        // Few minutes ago
        const minutes = Math.round(diff / this.minute)
        return `<span style='font-weight:bold;'>${minutes} mins</span>`
      } else if (diff < this.day) {
        // Few hours ago
        const hours = Math.floor(diff / this.hour)
        const seconds = diff % this.hour
        const minutes = Math.round(seconds / this.minute)
        return `${hours} hrs, ${minutes} mins`
      } else {
        return listingDate.format('MMMM Do YYYY, h:mm:ss a')
      }
    },
    getCharacterName (listing) {
      return listing['character_name'] ? listing['character_name'] : 'AHBOT'
    },
    getCss (listing) {
      return this.getSoldTime(listing) !== '-' ? 'background:#FCF5C9;' : ''
    },
    getIcon (listing) {
      return `http://static.ffxiah.com/images/icon/${listing['item_id']}.png`
    },
    getId (listing) {
      return listing['ah_id']
    },
    getItemName (listing) {
      return listing['item_name'].replace(/_/g, ' ')
    },
    getListTime(listing) {
      return this.getAuctionTimeAsString(listing['ah_date'])
    },
    getProfit (listing) {
      return this.getSoldTime(listing) !== '-' ?
        Number.parseFloat(this.getSoldPrice(listing) - this.getAhPrice(listing)) :
        '-'
    },
    getSoldTime(listing) {
      return listing['ah_saledate'] > 0 ?
        this.getAuctionTimeAsString(listing['ah_saledate']) :
        '-'
    },
    getSoldPrice (listing) {
      return this.getSoldTime(listing) !== '-' ?
        Number.parseFloat(listing['ah_sale']) :
        '-'
    },
    getStackCode (listing) {
      return listing['ah_stack'] === 0 ? '&#215;' : '&#10003;'
    }
  },
  template: `
      <tr :style="getCss(listing)">
          <td align="center" style="color: #aaa; font-size: 14px;">
              {{ getId(listing) }}
          </td>
          <td>
              <img :src="getIcon(listing)" style="margin:-3px -3px -5px -3px;" />
          </td>
          <td>
              {{ getItemName(listing) }}
          </td>
          <td align="center" class="generic-table-symbol" style="color:#aaa;">
              <span v-html="getStackCode(listing)"></span>
          </td>
          <td align="right">
              {{ getAhPrice(listing) }}
          </td>
          <td>
              {{ getListTime(listing) }}
          </td>
          <td align="right">
              {{ getSoldPrice(listing) }}
          </td>
          <td>
              {{ getSoldTime(listing) }}
          </td>
          <td>
              {{ getProfit(listing) }}
          </td>
          <td>
              {{ getCharacterName(listing) }}
          </td>
          <td align="center" class="form" style="padding: 0;">
              <span v-html="getAction(listing)"></span>
          </td>
      </tr>
    `
}