<template>
    <div :class="'card ' + statusCss">
        <div class="card-header">
            <p class="card-header-title">
                {{ charName }}
            </p>
            <div class="stack-icon tooltip" data-tooltip="Is a stack?">
                <font-awesome-icon :icon="stackCode" :size="'2x'" :pull="'right'" />
            </div>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        <img :src="icon" :alt="itemName" />
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-4">{{ itemName }}</p>
                    <p class="subtitle is-6">{{ itemId }}</p>
                    <p class="subtitle is-6">
                        <time :datetime="listTime">{{ listTime }}</time>
                    </p>
                </div>
                <div class="media-right title is-2">
                    {{ price }}
                </div>
            </div>
        </div>
        <div class="card-footer" v-if="isSold">
            <div class="card-footer-item">
                <div class="sold-item-title">Sold For</div>
                <div class="title is-3">{{ soldPrice }}</div>
            </div>
            <div class="card-footer-item">
                <div class="sold-item-title">Sold On</div>
                <div>{{ soldTime }}</div>
            </div>
            <div :class="'card-footer-item profit ' + profitClass">
                <div class="sold-item-title">Profit</div>
                <div class="title is-3">{{ profit }}</div>
            </div>
        </div>
        <div class="card-footer-item button is-link" v-else>
            Buy
        </div>
    </div>
</template>

<script>
import TimeHelper from '../../helper/TimeHelper.js'

const timeHelper = new TimeHelper()

export default {
  name: 'Listing',
  computed: {
    charName () {
      return this.listing['character_name'] ? this.listing['character_name'] : 'AHBOT'
    },
    icon () {
      return `http://static.ffxiah.com/images/icon/${this.itemId}.png`
    },
    isSold () {
      return this.listing['ah_saledate'] > 0
    },
    itemId () {
      return this.listing['item_id']
    },
    itemName () {
      return this.listing['item_name'].replace(/_/g, ' ')
    },
    listTime() {
      return timeHelper.getAuctionTimeAsString(this.listing['ah_date'])
    },
    price () {
      return Number.parseFloat(this.listing['ah_price'])
    },
    profit () {
      return this.soldTime !== '-' ?
        Number.parseFloat(this.soldPrice - this.price) :
        '-'
    },
    profitClass () {
      return this.profit > 0 ? 'ah-profit' : 'ah-noprofit'
    },
    soldPrice () {
      return this.soldTime !== '-' ?
        Number.parseFloat(this.listing['ah_sale']) :
        '-'
    },
    soldTime() {
      return this.isSold ?
        timeHelper.getAuctionTimeAsString(this.listing['ah_saledate']) :
        '-'
    },
    stackCode () {
      return parseInt(this.listing['ah_stack']) === 0 ? 'times' : 'check'
    },
    statusCss () {
      return this.isSold ? 'sold' : 'unsold'
    }
  },
  props: {
    fields: Object,
    index: Number,
    listing: Object
  },
  methods: {
  }
}
</script>

<style lang="scss">
    .card {
        margin-top: 20px;
        .media-content {
            .subtitle {
                margin-bottom: 0;
            }
        }
        .card-footer-item {
            flex-wrap: wrap;
            & div {
                min-width: 100%;
                text-align: center;
            }
            .sold-item-title {
                font-weight: bold;
            }
            &.profit {
                color: white;
                & .title {
                    color: white
                }
                &.ah-noprofit {
                    background-color: red;
                }
                &.ah-profit {
                    background-color: green;
                }
            }
        }
    }
    .sold {
        background: #FCF5C9;
    }
    .stack-icon {
        color: #aaa;
        margin: 10px;
    }
    .unsold {

    }
</style>