import TimeHelper from '../../helper/TimeHelper.js'

const timeHelper = new TimeHelper()

export default {
  name: 'Character',
  created () {
    fetch('http://dsweb.local/data/character/21828')
      .then(response => {
        return response.json()
      })
      .then(json => {
        this.character = json
        console.log(this.character)
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
  },
  template: `
    <div class="page">
      <h3>
          <span style="color:#888;">Character &raquo;</span> ( {{ getCharId }} ) {{ getCharName }}
      </h3>

      <h5>Account</h5>
      <table class="generic-table" border="0" cellpadding="10" cellspacing="0">
        <tr>
            <td>
                <span class="edit-label">ID</span> {{ getAccountId }}
            </td>
            <td>
                <span class="edit-label">Name</span> {{ getAccountName }}
            </td>
            <td>
                <span class="edit-label">Email #1</span> {{ getAccountEmail }}
            </td>
            <td>
                <span class="edit-label">Email #2</span> {{ getAccountSecondaryEmail }}
            </td>
            <td>
                <span class="edit-label">Created</span> {{ getAccountCreated }}
            </td>
            <td>
                <span class="edit-label">Modified</span> {{ getAccountModified }}
            </td>
            <td>
                <span class="edit-label">Status</span> {{ getAccountStatus }}
            </td>
            <td>
                <span class="edit-label">Privileges</span> {{ getAccountPrivileges }}
            </td>
        </tr>
      </table>

      <h5>Character</h5>
      <table class="generic-table" border="0" cellpadding="10" cellspacing="0">
          <tr>
              <td>
                <span class="edit-label">ID</span> {{ getCharId }}</td>
              <td><span class="edit-label">Name</span> {{ getCharName }}</td>
              <td><span class="edit-label">Gil</span> {{ getGil }}</td>
              <td><span class="edit-label">Rotation</span> {{ getCharRotation }}</td>
              <td><span class="edit-label">Position</span> {{ getCharPosition }}</td>
              <td><span class="edit-label">Boundary</span> {{ getCharBoundary }}</td>
              <td><span class="edit-label">Playtime</span> {{ getCharPlaytime }}</td>
              <td><span class="edit-label">GMLevel</span> {{ getCharGMLevel }}</td>
          </tr>
      </table>
    </div>
  `
}