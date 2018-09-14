<template>
    <div>
        <div :class="'modal ' + modalStyle" v-if="!authenticated">
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
                                   v-model="input.password"
                                   v-on:keyup="validatePass" />
                            <p class="help" :class="passStyles">{{ passHelpText }}</p>
                        </div>
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
           v-on:click="modalActive=true"
           v-if="!authenticated">Login</a>
        <div class="title is-4 is-pulled-right is-vcentered" v-else>Logged in as: {{ char.name }}</div>
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
      let auth = localStorage.getItem('dsweb-auth')
      if (auth) {
        auth = JSON.parse(auth)
        this.authenticated = auth.auth
        this.char = auth.character
      }
    },
    methods: {
      login () {
        console.log('foobarauth')
        if (this.validateChar() && this.validatePass()) {
          fetch(this.url, {
            method: 'POST',
            mode: 'same-origin',
            body: JSON.stringify(this.input),
            headers: {
              'Content-Type': 'application/json'
            }
          })
            .then(response => {
              console.log('success')
              return response.json()
            })
            .then(json => {
              console.log(json)
              if (json.auth === true) {
                console.log('LOGGED IN')
                this.authenticated = true
                localStorage.setItem('dsweb-auth', JSON.stringify(json))
                this.char = json.character
                // Close the modal now
                this.modalActive = false
              } else {
                if (localStorage.getItem('dsweb-auth')) {
                  localStorage.removeItem('dsweb-auth')
                }
                this.authenticated = false
                this.char = null
                this.loginFailText = 'Username or Password incorrect'
                this.loginFail = true
                this.charError = true
                this.charSuccess = false
                this.charHelpText = ''
                this.passError = true
                this.passSuccess = false
                this.passHelpText = ''
              }
            })
            .catch(e => {
              console.log(e)
            })
        }
      },
      validateChar () {
        if (this.input.characterName.length === 0) {
          this.charHelpText = 'Character Name must be supplied'
          this.charError = true
          this.charSuccess = false
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
</style>
