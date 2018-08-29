<template>
    <div class="search-category">
        <span style="color:#0057C1;">
            <h4>{{ categoryName }} <strong>( {{ resultsCount }} )</strong></h4>
            <table class="generic-table" border="0" cellpadding="10" cellspacing="0">
                <tr>
                    <th style="color:#000;" v-for="column in columns">{{ column }}</th>
                    <th align="right" style="color:#A74436;">options</th>
                </tr>
                <tr v-for="result in searchResults">
                    <td v-for="(value, column) in result"
                        :width="getWidth(column)">
                        {{ value }}
                    </td>
                    <td v-for="button in buttons" width="50px" align="right">
                        <font-awesome-icon icon="edit" />
                    </td>
                    <td v-if="!hasButtons" width="50px" align="right" style="color:#bbb;">n/a</td>
                </tr>
            </table>
        </span>
    </div>
</template>

<script>
export default {
  name: 'SearchResultsCategory',
  data () {
    return {
      buttons: [],
      columns: [],
      tableData: {
        // Table => [0] columns, [1] where search, [2] options
        // The unique id should ALWAYS be named id, it is used for unique identification
        'accounts': {
          'fields': ['id', 'login as name', 'email', 'email2'],
          'where': ['id', 'login', 'email', 'email2'],
          'buttons': ['edit']
        },
        'chars': {
          'fields': ['charid as id', 'charname as name', 'pos_zone as zone_id', 'playtime', 'gmlevel'],
          'where': ['charid', 'charname'],
          'buttons': ['edit']
        },
        'abilities': {
          'fields': ['abilityId as id', 'name'],
          'where': ['abilityId', 'name']
        },
        'item_weapon': {
          'fields': ['itemId as id', 'name'],
          'where': ['itemId', 'name']
        },
        'item_armor': {
          'fields': ['itemId as id', 'name'],
          'where': ['itemId', 'name']
        },
        'item_basic': {
          'fields': ['itemId as id', 'name'],
          'where': ['itemId', 'name']
        },
        'mob_pools': {
          'fields': ['poolid as id', 'name'],
          'where': ['poolid', 'name']
        },
        'spell_list': {
          'fields': ['spellid as id', 'name'],
          'where': ['spellid', 'name']
        },
        'zone_settings': {
          'fields': ['zoneid as id', 'name'],
          'where': ['zoneid', 'name']
        }
      }
    }
  },
  props: {
    categoryName: String,
    searchResults: {
      type: Array,
      default: []
    }
  },
  computed: {
    resultsCount () {
      return this.searchResults.length
    }
  },
  created () {
    if (this.tableData[this.categoryName]) {
      this.buttons = this.tableData[this.categoryName].buttons || []
      this.columns = this.tableData[this.categoryName].fields
    }
  },
  methods: {
    getWidth (column) {
      return column === 'id' ? '80px' : 'auto'
    },
    hasButtons () {
      return this.buttons.length > 0
    }
  }
}
</script>

<style>

</style>