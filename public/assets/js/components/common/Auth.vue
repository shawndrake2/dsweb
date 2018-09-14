<template>
    <div>
        <div v-if="!authenticated">
            <div :class="'modal ' + modalStyle">
                <div class="modal-background"></div>
                <div class="modal-content">
                    <div class="login">
                        <h2 class="title">Login as character</h2>
                        <p class="help title is-5" :class="loginStyles">{{ loginFailText }}</p>
                        <div class="field">
                            <label class="label">Character Name</label>
                            <div class="control">
                                <input class="input"
                                       :class="charStyles"
                                       type="text"
                                       placeholder="Character"
                                       ref="characterName"
                                       v-model="input.characterName"
                                       v-on:keyup="validateChar" />
                                <p class="help" :class="charStyles">{{ charHelpText }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input"
                                       :class="passStyles"
                                       type="password"
                                       placeholder="Password"
                                       ref="password"
                                       v-model="input.password"
                                       v-on:keyup="validatePass" />
                                <p class="help" :class="passStyles">{{ passHelpText }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" v-model="rememberLogin">
                                Stay logged in
                            </label>
                        </div>
                        <div>
                            <a class="button is-primary" v-on:click="login">Log In</a>
                        </div>
                    </div>
                </div>
                <button class="modal-close is-large" aria-label="close" v-on:click="modalActive=false"></button>
            </div>
            <a :class="authStyles"
               aria-label="close"
               v-on:click="showModal">Login</a>
        </div>
        <div v-else>
            <div class="title is-4 is-pulled-right is-vcentered">
                Logged in as: {{ char.name }} (<a class="logout tooltip" data-tooltip="Logout" v-on:click="logout">x</a>)
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'Auth',
    props: {
      classes: {
        type: Array,
        default: []
      }
    },
    data () {
      return {
        'authenticated': false,
        'char': null,
        'input': {
          'characterName': '',
          'password': ''
        },
        'modalActive': false,
        'charHelpText': '',
        'charError': false,
        'charSuccess': false,
        'loginFail': false,
        'loginFailText': '',
        'passHelpText': '',
        'passError': false,
        'passSuccess': false,
        'rememberLogin': false,
        'url': '/auth/login'
      }
    },
    computed: {
      authStyles () {
        return Array.isArray(this.classes) ? this.classes.join(' ') : ''
      },
      charStyles () {
        return {
          'is-danger': this.charError,
          'is-success': this.charSuccess
        }
      },
      loginStyles () {
        return {
          'is-danger': this.loginFail
        }
      },
      passStyles () {
        return {
          'is-danger': this.passError,
          'is-success': this.passSuccess
        }
      },
      modalStyle () {
        return this.modalActive ? 'is-active' : ''
      }
    },
    created () {
      this.recoverLogin()
      window.addEventListener('beforeunload', this.logoutOnClose)
    },
    methods: {
      login () {
        if (this.validateChar() && this.validatePass()) {
          const formData = new FormData()
          formData.append('characterName', this.input.characterName)
          formData.append('password', this.input.password)
          fetch(this.url, {
            method: 'POST',
            body: formData
          })
            .then(response => {
              return response.json()
            })
            .then(json => {
              if (json.auth === true) {
                this.authenticated = true
                this.char = json.character
                localStorage.setItem('dsweb-auth', JSON.stringify(json))
                localStorage.setItem('dsweb-storeLogin', this.rememberLogin)
                if (this.rememberLogin === true) {
                  window.removeEventListener('beforeunload', this.logout)
                }
                // Close the modal now
                this.modalActive = false
              } else {
                // Just to be safe, we run the logout method
                this.logout()
                this.loginFailText = 'Username or Password incorrect'
                this.loginFail = true
                this.charError = true
                this.charSuccess = false
                this.charHelpText = ''
                this.passError = true
                this.passSuccess = false
                this.passHelpText = ''
                // Set focus to character name input
                this.$nextTick(() => this.$refs.characterName.focus())
              }
            })
            .catch(e => {
              console.log(e)
            })
        }
      },
      logout () {
        console.log('LOGOUT')
        localStorage.removeItem('dsweb-auth')
        this.authenticated = false
        this.char = null
        this.rememberLogin = false
      },
      logoutOnClose () {
        if (!this.rememberLogin) {
          this.logout()
        }
      },
      recoverLogin () {
        const rememberLogin = localStorage.getItem('dsweb-storeLogin')
        this.rememberLogin = rememberLogin ? rememberLogin === 'true' : false
        if (this.rememberLogin === true) {
          let auth = localStorage.getItem('dsweb-auth')
          if (auth) {
            auth = JSON.parse(auth)
            this.authenticated = auth.auth
            this.char = auth.character
          }
        }
      },
      showModal () {
        this.modalActive = true
        // Set focus to character name input
        this.$nextTick(() => this.$refs.characterName.focus())
      },
      validateChar () {
        if (this.input.characterName.length === 0) {
          this.charHelpText = 'Character Name must be supplied'
          this.charError = true
          this.charSuccess = false
          // Set focus to character name input
          this.$nextTick(() => this.$refs.characterName.focus())
          return false
        } else {
          this.charHelpText = ''
          this.charError = false
          this.charSuccess = true
          return true
        }
      },
      validatePass () {
        if (this.input.password.length === 0) {
          this.passHelpText = 'Password must be supplied'
          this.passError = true
          this.passSuccess = false
          // Set focus to password input
          this.$nextTick(() => this.$refs.password.focus())
          return false
        } else {
          this.passHelpText = ''
          this.passError = false
          this.passSuccess = true
          return true
        }
      }
    }
  }
</script>

<style lang="scss">
    .login {
        background-color: white;
        padding: 10px;
    }
    .logout {
        color: black;
    }
</style>
