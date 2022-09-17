<template>
  <div id="app">
    <VideoRecord />
  </div>
</template>

<script>
import VideoRecord from './components/VideoRecord.vue'

export default {
  name: 'App',
  components: {
    VideoRecord,
  },
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #fff;
  margin-top: 60px;
}
body {
  background-color: #222;
  margin: 0;
  padding: 0;
}
</style>
