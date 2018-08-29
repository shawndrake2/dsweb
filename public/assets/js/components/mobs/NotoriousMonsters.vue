<template>
    <div class="page">
        <h3>Notorious Monsters</h3>
        <div class="error" v-if="isEmpty(mobs)">
            There are no unclaimed Notorious Monsters for you to battle.
        </div>
    </div>
</template>

<script>
export default {
  name: 'NotoriousMonsters',
  // created () {
  //   fetch('http://dsweb.local/data/mobs/notorious')
  //     .then(response => {
  //       return response.json()
  //     })
  //     .then(json => {
  //       this.mobs = json
  //     })
  //     .catch(e => {
  //       console.log(e)
  //     })
  // },
  data () {
    return {
      mobs: []
    }
  },
  methods: {
    isEmpty (obj) {
      return !obj || Object.keys(obj).length === 0;
    }
  }
}
</script>

<style>

</style>