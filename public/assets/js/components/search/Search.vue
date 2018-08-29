<template>
    <div class="page">
        <h3>Search</h3>
        <div class="form">
            <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td style="padding:0 10px 0 0;">
                        <input type="searchquery"
                               id="searchquery"
                               style="width:100%;"
                               :placeholder="placeholder"
                               v-on:keyup="search"
                               v-model="query">
                    </td>
                    <td width="2%">
                        <input type="button" value="Search" />
                    </td>
                </tr>
            </table>
        </div>
        <div style="height:30px;"></div>
        <div id="searchresults">
            <div v-for="(results, category) in searchResults">
                <app-results-category :categoryName="category" :searchResults="results"></app-results-category>
            </div>
        </div>
    </div>
</template>

<script>
import SearchResultsCategory from './SearchResultsCategory.vue'

export default {
  name: 'Search',
  components: {
    'app-results-category': SearchResultsCategory
  },
  data: () => {
    return {
      minSearchLength: 3,
      placeholder: 'Type in a character name, skill, zone, mob. Search also accepts the same filters as ingame.',
      query: '',
      searchResults: {}
    }
  },
  methods: {
    search () {
      if (this.query.length >= this.minSearchLength) {
        fetch(`http://dsweb.local/data/search?query=${this.query}`)
          .then(response => {
            return response.json()
          })
          .then(json => {
            this.searchResults = json
          })
          .catch(e => {
            console.log(e)
          })
      }
    }
  }
}
</script>

<style>

</style>