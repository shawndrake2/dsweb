<template>
    <div class="columns" :style="getCss(listing)">
        <div class="column" v-if="fields.itemId" style="color: #aaa; font-size: 14px;">
            {{ getId(listing) }}
        </div>
        <div class="column" v-if="fields.icon">
            <figure class="image is-32x32">
                <img :src="getIcon(listing)" style="margin:-3px -3px -5px -3px;" />
            </figure>
        </div>
        <div class="column" v-if="fields.itemName">
            {{ getItemName(listing) }}
        </div>
        <div class="column" v-if="fields.stack" style="color:#aaa;">
            <font-awesome-icon :icon="getStackCode(listing)" :size="'2x'" />
        </div>
        <div class="column is-centered" v-if="fields.price" align="right">
            {{ getAhPrice(listing) }}
        </div>
        <div class="column" v-if="fields.listDate">
            {{ getListTime(listing) }}
        </div>
        <div class="column" v-if="fields.salePrice" align="right">
            {{ getSoldPrice(listing) }}
        </div>
        <div class="column" v-if="fields.saleDate">
            {{ getSoldTime(listing) }}
        </div>
        <div class="column" v-if="fields.profit">
            {{ getProfit(listing) }}
        </div>
        <div class="column" v-if="fields.seller">
            {{ getCharacterName(listing) }}
        </div>
        <div class="column form" v-if="fields.actions" style="padding: 0;">
            <span v-html="getAction(listing)"></span>
        </div>
    </div>
</template>

<script>
import TimeHelper from '../../helper/TimeHelper.js'

const timeHelper = new TimeHelper()

export default {
  name: 'Listing',
  props: {
    fields: Object,
    index: Number,
    listing: Object
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
      return listing['item_id']
    },
    getItemName (listing) {
      return listing['item_name'].replace(/_/g, ' ')
    },
    getListTime(listing) {
      return timeHelper.getAuctionTimeAsString(listing['ah_date'])
    },
    getProfit (listing) {
      return this.getSoldTime(listing) !== '-' ?
        Number.parseFloat(this.getSoldPrice(listing) - this.getAhPrice(listing)) :
        '-'
    },
    getSoldTime(listing) {
      return listing['ah_saledate'] > 0 ?
        timeHelper.getAuctionTimeAsString(listing['ah_saledate']) :
        '-'
    },
    getSoldPrice (listing) {
      return this.getSoldTime(listing) !== '-' ?
        Number.parseFloat(listing['ah_sale']) :
        '-'
    },
    getStackCode (listing) {
      return parseInt(listing['ah_stack']) === 0 ? 'times' : 'check'
    }
  }
}
</script>

<style>

</style>