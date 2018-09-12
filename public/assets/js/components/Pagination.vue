<template>
    <nav class="pagination" role="navigation" aria-label="pagination">
        <a class="pagination-previous"
           :disabled="disablePrev"
            v-on:click="$emit('previous-page')">Previous</a>
        <a class="pagination-next"
           :disabled="disableNext"
           v-on:click="$emit('next-page')">Next page</a>
        <ul class="pagination-list" v-if="totalPages <= 5">
            <li v-for="pageNum in totalPages">
                <a :class="'pagination-link ' + active(pageNum)"
                   :aria-label="'Goto page ' + pageNum"
                   v-on:click="$emit('goto-page', pageNum)">{{ pageNum }}</a>
            </li>
        </ul>
        <ul class="pagination-list" v-else>
            <li>
                <a :class="'pagination-link ' + active(1)"
                   :aria-label="'Goto page ' + 1"
                   v-on:click="$emit('goto-page', 1)">{{ 1 }}</a>
            </li>
            <li v-if="currentPage > (tabs[0] + 1)">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li v-for="pageNum in tabs">
                <a :class="'pagination-link ' + active(currentTab(pageNum))"
                   :aria-label="'Goto page ' + currentTab(pageNum)"
                   v-on:click="$emit('goto-page', currentTab(pageNum))"
                   v-if="currentTab(pageNum)">{{ currentTab(pageNum) }}</a>
            </li>
            <li v-if="currentPage + 2 < totalPages - 1">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li>
                <a :class="'pagination-link ' + active(totalPages)"
                   :aria-label="'Goto page ' + totalPages"
                   v-on:click="$emit('goto-page', totalPages)">{{ totalPages }}</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
  name: 'Pagination',
  data () {
    return {
      tabs: [2,3,4]
    }
  },
  computed: {
    disableNext () {
      return this.currentPage === this.totalPages
    },
    disablePrev () {
      return this.currentPage === 1
    }
  },
  methods: {
    active (pageNum) {
      return this.currentPage === pageNum ? 'is-current' : ''
    },
    currentTab (tab) {
      if (this.currentPage < 3) {
        return tab
      } else if (this.currentPage >= this.totalPages - 3) {
        return this.totalPages - 5 + tab
      } else if (this.currentPage === 1 && this.currentPage === this.totalPages) {
        return false
      } else {
        return this.currentPage + tab - 3
      }
    }
  },
  props: {
    currentPage: Number,
    totalPages: Number
  }
}
</script>

<style lang="scss">
    .pagination {
        margin-top: 20px;
    }
</style>