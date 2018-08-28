// Defined at PHP level for simplicity
const serverConfig = window.serverConfig;

export default {
  name: 'ServerDetails',
  data () {
    return {
      serverConfig: Object.entries(serverConfig)
    }
  },
  template: `
    <pre>
        <div v-for="config in serverConfig">{{ serverConfig }}</div>
    </pre>
    `
}