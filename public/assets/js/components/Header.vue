<template>
    <header>
        <h1 class="logo">
            {{ siteName }}
        </h1>
        <div>
            <a href="#">Login</a>
        </div>
    </header>
</template>

<script>
export default {
  name: 'Header',
  props: {
    siteName: String
  }
}
</script>

<style>
    .logo {
        margin: 20px 0 0 0;
        font-size: 32px;
        font-family: Arial;
        letter-spacing: -1px;
    }
</style>