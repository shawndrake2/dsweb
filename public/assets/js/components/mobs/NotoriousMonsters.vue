<template>
    <div class="page">
        <h3>Notorious Monsters</h3>
        <div v-if="!isEmpty(mobs)">
            <table>
                <thead>
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Zone Id
                        </th>
                        <th>
                            Zone Name
                        </th>
                        <th>
                            Position (X)
                        </th>
                        <th>
                            Position (Y)
                        </th>
                        <th>
                            Position (Z)
                        </th>
                        <th>
                            On the move?
                        </th>
                    </tr>
                </thead>
                <tbody v-for="(zoneNms,zone) in mobs">
                    <tr>
                        <th colspan="8" align="left">{{ zone }}</th>
                    </tr>
                    <tr v-for="mob in zoneNms">
                        <td>{{ mob.mobId }}</td>
                        <td>{{ mob.name }}</td>
                        <td>{{ mob.zoneId }}</td>
                        <td>{{ mob.zone }}</td>
                        <td>{{ mob.locX }}</td>
                        <td>{{ mob.locY }}</td>
                        <td>{{ mob.locZ }}</td>
                        <td>{{ onTheMove(parseInt(mob.moving)) }}</td>
                    </tr>
                </tbody>
            </table>
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
    onTheMove (value) {
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