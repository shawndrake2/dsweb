<template>
    <div class="page">
        <h2 class="title is-3">Notorious Monsters</h2>
        <div v-if="!isEmpty(mobs)">
            <div class="columns">
                <div class="column">
                    <div class="title is-6">
                        Id
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Name
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Zone Id
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Zone Name
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Position (X)
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Position (Y)
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        Position (Z)
                    </div>
                </div>
                <div class="column">
                    <div class="title is-6">
                        On the move?
                    </div>
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