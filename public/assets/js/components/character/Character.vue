<template>
    <div class="page">
        <h2 class="title is-3">
            <span>Character &raquo;</span> ( {{ getCharId }} ) {{ getCharName }}
        </h2>

        <h3 class="title is-5">Account</h3>
        <div class="columns">
            <div class="column">
                <div class="title is-6">ID</div> {{ getAccountId }}
            </div>
            <div class="column">
                <div class="title is-6">Name</div> {{ getAccountName }}
            </div>
            <div class="column">
                <div class="title is-6">Email #1</div> {{ getAccountEmail }}
            </div>
            <div class="column">
                <div class="title is-6">Email #2</div> {{ getAccountSecondaryEmail }}
            </div>
            <div class="column">
                <div class="title is-6">Created</div> {{ getAccountCreated }}
            </div>
            <div class="column">
                <div class="title is-6">Modified</div> {{ getAccountModified }}
            </div>
            <div class="column">
                <div class="title is-6">Status</div> {{ getAccountStatus }}
            </div>
            <div class="column">
                <div class="title is-6">Privileges</div> {{ getAccountPrivileges }}
            </div>
        </div>

        <h3 class="title is-5">Character</h3>
        <div class="columns">
            <div class="column"><div class="title is-6">ID</div> {{ getCharId }}</div>
            <div class="column"><div class="title is-6">Name</div> {{ getCharName }}</div>
            <div class="column"><div class="title is-6">Gil</div> {{ getGil }}</div>
            <div class="column"><div class="title is-6">Rotation</div> {{ getCharRotation }}</div>
            <div class="column"><div class="title is-6">Position</div> {{ getCharPosition }}</div>
            <div class="column"><div class="title is-6">Boundary</div> {{ getCharBoundary }}</div>
            <div class="column"><div class="title is-6">Playtime</div> {{ getCharPlaytime }}</div>
            <div class="column"><div class="title is-6">GMLevel</div> {{ getCharGMLevel }}</div>
        </div>
    </div>
</template>

<script>
import TimeHelper from '../../helper/TimeHelper.js'

const timeHelper = new TimeHelper()

export default {
  name: 'Character',
  created () {
    fetch('/data/character/21828')
      .then(response => {
        return response.json()
      })
      .then(json => {
        this.character = json
      })
      .catch(e => {
        console.log(e)
      })
  },
  data () {
    return {
      character: {}
    }
  },
  methods: {
    getValueFromAccount(key) {
      if (this.character && this.character.acc && this.character.acc[key]) {
        return this.character.acc[key]
      }
      return null
    },
    getValueFromMain(key) {
      if (this.character && this.character.main && this.character.main[key]) {
        return this.character.main[key]
      }
      return null
    }
  },
  computed: {
    getAccountCreated: function () {
      return this.getValueFromAccount('created')
    },
    getAccountEmail: function () {
      return this.getValueFromAccount('email1')
    },
    getAccountId: function () {
      return this.getValueFromAccount('id')
    },
    getAccountModified: function () {
      return this.getValueFromAccount('modified')
    },
    getAccountName: function () {
      return this.getValueFromAccount('name')
    },
    getAccountPrivileges: function () {
      return this.getValueFromAccount('privledges')
    },
    getAccountSecondaryEmail: function () {
      return this.getValueFromAccount('email2')
    },
    getAccountStatus: function () {
      return this.getValueFromAccount('status')
    },
    getCharBoundary: function () {
      return this.getValueFromMain('boundary')
    },
    getCharGMLevel: function () {
      return this.getValueFromMain('gmlevel')
    },
    getCharId: function () {
      return this.getValueFromMain('id')
    },
    getCharName: function () {
      return this.getValueFromMain('name')
    },
    getCharPosition: function () {
      const x = this.getValueFromMain('x') || 0
      const y = this.getValueFromMain('y') || 0
      const z = this.getValueFromMain('z') || 0
      return {
        x: x,
        y: y,
        z: z
      }
    },
    getCharPlaytime: function () {
      return timeHelper.getPlaytimeAsString(this.getValueFromMain('playtime'))
    },
    getCharRotation: function () {
      return this.getValueFromMain('rotation')
    },
    getGil: function () {
      return this.character.gil || 0
    }
  }
}
</script>

<style>

</style>