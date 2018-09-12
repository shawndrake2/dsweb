<template>
    <div class="page">
        <h2 class="title is-3">Notorious Monsters</h2>
        <div v-if="!isEmpty(mobs)">
            <div class="columns">
                <div class="column">
                    Id
                </div>
                <div class="column">
                    Name
                </div>
                <div class="column">
                    Zone Id
                </div>
                <div class="column">
                    Zone Name
                </div>
                <div class="column">
                    Position (X)
                </div>
                <div class="column">
                    Position (Y)
                </div>
                <div class="column">
                    Position (Z)
                </div>
                <div class="column">
                    On the move?
                </div>
            </div>
            <div v-for="(zoneNms,zone) in mobs">
                <div>
                    <div class="title is-5">{{ zone }}</div>
                </div>
                <div class="columns" v-for="mob in zoneNms">
                    <div class="column">{{ mob.mobId }}</div>
                    <div class="column">{{ mob.name }}</div>
                    <div class="column">{{ mob.zoneId }}</div>
                    <div class="column">{{ mob.zone }}</div>
                    <div class="column">{{ mob.locX }}</div>
                    <div class="column">{{ mob.locY }}</div>
                    <div class="column">{{ mob.locZ }}</div>
                    <div class="column">{{ ontheMove(parseInt(mob.moving)) }}</div>
                </div>
            </div>
        </div>
        <div class="notification is-danger" v-else>
            There are no unclaimed Notorious Monsters for you to battle.
        </div>
    </div>
</template>

<script>
export default {
  name: 'NotoriousMonsters',
  created () {
    this.fetchData()
    setInterval(() => {
      this.fetchData()
    }, 10000)
  },
  data () {
    return {
      mobs: [],
      zoneOutput: null
    }
  },
  methods: {
    fetchData () {
      fetch('/data/mobs/notorious')
        .then(response => {
          return response.json()
        })
        .then(json => {
          this.mobs = json
        })
        .catch(e => {
          console.log(e)
        })
    },
    isEmpty (obj) {
      return !obj || Object.keys(obj).length === 0;
    },
    ontheMove (value) {
      return value === 0 ? 'No' : 'Yes'
    },
    nextZone (zone) {
      if (zone !== this.zoneOutput) {
        this.zoneOutput = zone
        return true
      }
      return false
    }
  }
}
</script>

<style>

</style>