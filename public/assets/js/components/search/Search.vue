<template>
    <div class="page">
        <h2 class="title is-3">Search</h2>
        <div class="field">
            <div class="control">
                <input type="text"
                       class="input is-large"
                       :placeholder="placeholder"
                       v-on:keyup="search"
                       v-model="query" />
            </div>
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
        fetch(`/data/search?query=${this.query}`)
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